@servers(['web' => '192.168.0.5'])

@task('deploy', ['on' => 'web', 'comfirm' => true])
    cd /var/www/pw.peach-x
    git pull
    sh cache_clear.sh
@endtask