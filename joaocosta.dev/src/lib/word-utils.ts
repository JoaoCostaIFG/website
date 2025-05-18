export function countWords(text: string) {
  return text.split(' ')
    .filter(function (n) { return n != '' })
    .length;
}

export function readingTime(text: string) {
  const AVG_WPM = 238
  const totalWords = countWords(text)
  return Math.ceil(totalWords / AVG_WPM)
}
