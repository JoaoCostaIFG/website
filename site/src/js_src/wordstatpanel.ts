import {EditorState, Extension, Text} from "@codemirror/state"
import {Panel, showPanel} from "@codemirror/view"
import {EditorView} from "codemirror"

function countWords(doc: Text) {
  let wordCnt = 0, iter = doc.iter()

  while (!iter.next().done) {
    let inWord = false
    for (let i = 0; i < iter.value.length; ++i) {
      let word = /\w/.test(iter.value[i])
      if (word && !inWord) ++wordCnt
      inWord = word
    }
  }
  return `w: ${wordCnt}`
}

function currentLine(state: EditorState) {
  let doc = state.doc;
  let selStart = state.selection.ranges[0].from
  let line = doc.lineAt(selStart);
  return `${Math.round(line.number * 100 / doc.lines)}% ln:${line.number}/${doc.lines} :${selStart - line.from}`
}

function wordStatPanel(view: EditorView): Panel {
  let dom = document.createElement("div"),
    wordsSpan = document.createElement("span"),
    linesSpan = document.createElement("span");

  dom.appendChild(wordsSpan);
  dom.appendChild(linesSpan);

  wordsSpan.textContent = `${countWords(view.state.doc)} | `;
  linesSpan.textContent = `${currentLine(view.state)}`;

  return {
    dom,
    update(update) {
      if (update.docChanged)
        wordsSpan.textContent = `${countWords(update.view.state.doc)} | `;
      if (update.selectionSet)
        linesSpan.textContent = `${currentLine(update.view.state)}`;
    },
  };
}

export default function WordStatPanel(): Extension {
  return showPanel.of(wordStatPanel);
}
