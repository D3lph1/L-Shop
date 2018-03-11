export default class Transliterator {
    static get RUS() {
        return "щ   ш  ч  ц  ю  я  ё  ж  ъ  ы  э  а б в г д е з и й к л м н о п р с т у ф х ь".split(/ +/g);
    }

    static get ENG() {
        return "shh sh ch cz yu ya yo zh `` y' e` a b v g d e z i j k l m n o p r s t u f x `".split(/ +/g);
    }

    static rusToEng(text) {
        for (let i = 0; i < Transliterator.RUS.length; i++) {
            text = text.split(Transliterator.RUS[i]).join(Transliterator.ENG[i]);
            text = text.split(Transliterator.RUS[i].toUpperCase()).join(Transliterator.ENG[i].toUpperCase());
        }

        return text;
    }

    static engToRus(text) {
        for (let i = 0; i < Transliterator.RUS.length; i++) {
            text = text.split(Transliterator.ENG[i]).join(Transliterator.RUS[i]);
            text = text.split(Transliterator.ENG[i].toUpperCase()).join(Transliterator.RUS[i].toUpperCase());
        }

        return text;
    }

    static slaggade(text) {
        return text.trim().replace(/[\s]/ig, '-').replace(/[^a-zа-я0-9\-]+/ig, '').toLowerCase();
    }
}
