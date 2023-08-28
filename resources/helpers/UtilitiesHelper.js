export function capitalizeFLetter(value) {
    if (typeof value !== 'string') {
        throw new Error('Input must be a string');
    }

    if (value.length === 0) {
        return value;
    }

    const firstChar = value.charAt(0).toUpperCase();
    const remainingChars = value.slice(1);
    return `${firstChar}${remainingChars}`;
}
