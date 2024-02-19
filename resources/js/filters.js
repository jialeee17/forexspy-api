export const currency = (value) => {
    if (typeof value !== "number") {
        value = Number(value);
        if (isNaN(value)) {
            return value;
        }
    }

    const formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        // minimumFractionDigits: value % 1 === 0 ? 0 : 2,
        maximumFractionDigits: 2,
    });

    const formattedValue = formatter.format(value);
    const spaceSeparatedValue = formattedValue.replace(
        /(\D*)(\d+)\s?(\.\d+)?(\D*)/,
        "$1 $2$3$4"
    );
    return spaceSeparatedValue;
};

export const percentage = (value, digit = 2) => {
    if (value > 0) {
        return parseFloat(value).toFixed(digit) + "%";
    } else return parseFloat(value).toFixed(digit) + "%";
};

export const percentage_colour = (value) => {
    if (value === 0) {
        return "text-secondary";
    } else if (value > 0) {
        return "text-success";
    } else return "text-danger";
};

export const avatar = (image, name) => {
    return !image
        ? `https://ui-avatars.com/api/?name=${name}&color=7F9CF5&background=EBF4FF`
        : image;
};

export const twoDigit = (num) => {
    return num.toString().padStart(2, "0");
};
