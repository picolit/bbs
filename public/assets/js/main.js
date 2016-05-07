function playOmikuji(age, name) {
    var kuji = '';
    if (age === 17) {
        kuji = "大吉";
    }
    else {
        kuji = "凶";
    }
    return name + "さんの運勢は" + kuji + "です";
}
var age = 17;
var name = "慧";
var unsei = playOmikuji(age, name);
