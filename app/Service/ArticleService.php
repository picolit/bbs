<?php namespace App\Service;


use \App\Orm\Article;
use App\Orm\Interest;
use App\Orm\Photo;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ArticleService
 * @package App\Service
 */
class ArticleService
{
    const PAGENATE_PER_PAGE = 5;

    /** @var Article */
    private $article;
    /** @var AnalysisService */
    private $analysisService;
    /** @var Interest */
    private $interest;
    /** @var Mailer */
    private $mailer;

    /**
     * Constructor
     * @param Article $article
     * @param AnalysisService $analysisService
     * @param Interest $interest
     * @param Mailer $mailer
     */
    public function __construct(Article $article, AnalysisService $analysisService, Interest $interest, Mailer $mailer)
    {
        $this->article = $article;
        $this->analysisService = $analysisService;
        $this->interest = $interest;
        $this->mailer = $mailer;
    }

    /**
     * 記事を取得
     * @param array $conditions
     * @return mixed
     */
    public function get(array $conditions)
    {
        return $this->article->search($conditions)->sort()->paginate(self::PAGENATE_PER_PAGE);
    }

    /**
     * articlesとphotosへ格納
     * @param array $data
     */
    public function create(array $data)
    {
        DB::transaction(function () use ($data) {
            $this->article->newInstance();
            $this->article->{'res_id'} = $data['parent_id'];
            $this->article->{'name'} = $data['name'];
            $this->article->{'age'} = $data['age'];
            $this->article->{'sex'} = $data['sex'];
            $this->article->{'prefectures'} = $data['prefectures'];
            $this->article->{'title'} = $data['title'];
            $this->article->{'body'} = $data['body'];
            $this->article->{'mail'} = $data['mail'];
//            $this->article->{'password'} = $data['password'];
            $this->article->{'ip_address'} = $data['client_ip'];
            $this->article->save();

            // 返信の場合、親のupdate_atを更新
            $parentArticle = $this->article->newInstance();
            if ($this->article->{'res_id'} !== '0') {
                $parentArticle->find($this->article->{'res_id'})->touch();
                // @todo キューでおこなう
                $this->sendMail($this->article, $parentArticle->{'name'});
            }

            $photos = [];

            for ($i = 1; $i <= 2; $i++) {
                if (isset($data['file' . $i])) {
                    $file1Result = $this->getExifReadData($data['file' . $i]);
                    if ($file1Result) {
                        $photos[] = new Photo($file1Result);
                    }
                }
            }

            if ($photos) {
                $this->article->photos()->saveMany($photos);
            }

            $interests = $this->interest->all();
            foreach ($interests as $row) {
                if (isset($data[$row->name_tag])) {
                    $this->article->interests()->attach($data[$row->name_tag]);
                }
            }

            // 新規記事件数インクリメント
            if ($this->article->{'res_id'} === 0) {
                $this->analysisService->newPostIncrement();
            }
        });
    }

    /**
     * @param UploadedFile $fileObject
     * @return array
     */
    private function getExifReadData(UploadedFile $fileObject)
    {
        Log::debug($fileObject->getPath());
        Log::debug($fileObject->getFilename());
        Log::debug($fileObject->getBasename());
        Log::debug($fileObject->getMimeType());
        Log::debug($fileObject->getExtension());
        Log::debug($fileObject->getType());

        $result = [];
        $mimeType = $fileObject->getMimeType();

        // upload_igm and thumbnail directory make
        $dirName = date('Ym');
        $uploadDir = public_path() . '/upload_img/' . $dirName;
        $thumbnailDir = public_path() . '/thumbnail/' . $dirName;

        $this->chkDir($uploadDir);
        $this->chkDir($thumbnailDir);
//@todo オリジナル動画をリサイズする
        $extension = explode('/', $fileObject->getMimeType())[1];
        $newFileName = sha1($fileObject->getFilename() . time()) . '.' . $extension;
        $saveFileName = $uploadDir . '/' . $newFileName;
        $fileObject->move($uploadDir, $newFileName);

        $thumbnail = Image::make(file_get_contents($saveFileName));
        $thumbnail->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $thumbnail->save($thumbnailDir . '/' . $newFileName, 100);

        $result['file_name'] = $dirName . '/' . $newFileName;

        if ($mimeType !== 'image/jpeg') {
            return $result;
        }

        $exif = exif_read_data($saveFileName);

        if ($exif === false) return false;


        $result['file_date_time'] = isset($exif['DateTimeOriginal']) ? $exif['DateTimeOriginal'] : null;
        $result['file_size'] = $exif['FileSize'];
        $result['mime_type'] = $exif['MimeType'];
        $result['width'] = $exif['COMPUTED']['Width'];
        $result['height'] = $exif['COMPUTED']['Height'];
        $result['make'] = isset($exif['Make']) ? $exif['Make'] : null;
        $result['model'] = isset($exif['Model']) ? $exif['Model'] : null;
        $result['orientation'] = isset($exif['Orientation']) ? $exif['Orientation'] : null;

        if (isset($exif["GPSLatitude"])) {
            //緯度を60進数から10進数に変換
            $lat = $this->convert_float($exif["GPSLatitude"][0]) + ($this->convert_float($exif["GPSLatitude"][1]) / 60) + ($this->convert_float($exif["GPSLatitude"][2]) / 3600);

            //南緯の場合はマイナスにする
            if ($exif["GPSLatitudeRef"] == "S") {
                $lat *= -1;
            }

            //経度を60進数から10進数に変換
            $lng = $this->convert_float($exif["GPSLongitude"][0]) + ($this->convert_float($exif["GPSLongitude"][1]) / 60) + ($this->convert_float($exif["GPSLongitude"][2]) / 3600);

            //西経の場合はマイナスにする
            if ($exif["GPSLongitudeRef"] == "W") {
                $lng *= -1;
            }

            $result['lat'] = $lat;
            $result['lng'] = $lng;
        }

        return $result;
    }

    /**
     * [例:986/100]という文字列を[986÷100=9.86]というように数値に変換する関数
     * @param $str
     * @return float
     */
    private function convert_float($str)
    {
        $val = explode("/", $str);
        return (isset($val[1])) ? $val[0] / $val[1] : $str;
    }

    /**
     *
     * @param string $dirpath
     * @param bool|true $create_flg
     * @return bool
     */
    private function chkDir($dirpath, $create_flg = true)
    {
        $return = false;

        if (file_exists($dirpath)) {
            $return = true;
        }
        if (!$return) {
            if ($create_flg) {
                mkdir($dirpath, 0777);
                chmod($dirpath, 0777);
            }
            $return = true;
        }

        return $return;
    }

    /**
     * @todo キューで送る
     * @param Article $article
     * @param string $toName
     */
    private function sendMail(Article $article, $toName)
    {
        if ($article->{'mail'}) {
            $this->mailer->send(
                'parts.reply_mail',
                ['article' => $article, 'toName' => $toName],
                function ($message) use ($article) {
                    $message->to($article->{'mail'}, 'テスト')->subject($article->{'name'} . 'さんから返信が届きました');
                }
            );
        }
    }
}