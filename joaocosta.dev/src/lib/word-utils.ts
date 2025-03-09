export function countWords(text: string) {
  return text.split(' ')
    .filter(function (n) { return n != '' })
    .length;
}
