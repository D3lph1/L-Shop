export default class Colors {
    static incrementHexColor(hexColor, value) {
        let r = parseInt(hexColor.slice(1, 3), 16);
        let g = parseInt(hexColor.slice(3, 5), 16);
        let b = parseInt(hexColor.slice(5, 7), 16);

        b += value;
        if (b > 255) {
            let delta = b - 255;
            b = 255;
            g += delta;
            if (g > 255) {
                r += g - 255;
                g = 255;
                if (r > 255) {
                    r = 255;
                }
            }
        }

        return '#' + r.toString(16) + g.toString(16) + b.toString(16);
    }

    static decrementHexColor(hexColor, value) {
        let r = parseInt(hexColor.slice(1, 3), 16);
        let g = parseInt(hexColor.slice(3, 5), 16);
        let b = parseInt(hexColor.slice(5, 7), 16);

        b -= value;
        if (b < 0) {
            let delta = b - 255;
            b = 0;
            g -= delta;
            if (g < 0) {
                r += g - 255;
                g = 0;
                if (r < 0) {
                    r = 0;
                }
            }
        }

        return '#' + r.toString(16) + g.toString(16) + b.toString(16);
    }
}
