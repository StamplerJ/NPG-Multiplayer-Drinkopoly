class Player {

    constructor(name, fieldIndex, color) {
        this.name = name;
        this.fieldIndex = fieldIndex;
        this.color = color;
    }

    draw(context, x, y, radius) {
        context.beginPath();
        context.arc(x, y, radius, 0, 2 * Math.PI, false);
        context.fillStyle = this.color;
        context.fill();
        context.fillStyle = "#000000";
    }
}