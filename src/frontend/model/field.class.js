class Field {

    constructor(index, xIndex, yIndex, width, height) {
        this.index = index;
        this.xIndex = xIndex;
        this.yIndex = yIndex;
        this.x = xIndex * width;
        this.y = yIndex * height;
        this.width = width;
        this.height = height;
        this.text = "";
        this.game = "";
    }

    draw(context) {
        context.strokeRect(this.x, this.y , this.width, this.height);

        context.textAlign = "center";
        let lines = this.getLines(context, this.text, this.width);
        for (let i = 0; i < lines.length; i++) {
            context.fillText(lines[i], this.x + this.width / 2, this.y + (i + 1) * 32); // 32 is the font size
        }
    }

    getLines(ctx, text, maxWidth) {
        let words = text.split(" ");
        let lines = [];
        let currentLine = words[0];

        for (let i = 1; i < words.length; i++) {
            let word = words[i];
            let width = ctx.measureText(currentLine + " " + word).width;
            if (width < maxWidth) {
                currentLine += " " + word;
            } else {
                lines.push(currentLine);
                currentLine = word;
            }
        }
        lines.push(currentLine);
        return lines;
    }
}