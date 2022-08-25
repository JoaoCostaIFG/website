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
  return `ln:${line.number}/${doc.lines} (${Math.round(line.number * 100 / doc.lines)}%) :${selStart - line.from}`
}

function wordStatPanel(view: EditorView): Panel {
  const dom = document.createElement("div")
  dom.style.display = "flex"
  dom.style.justifyContent = "flex-start"
  dom.style.flexWrap = "wrap"
  dom.style.gap = "1em"
  dom.style.padding = "0 1em 0"

  const wordsSpan = dom.appendChild(document.createElement("span"))
  wordsSpan.textContent = countWords(view.state.doc);
  dom.appendChild(document.createElement("span")).textContent = "|" // spacer

  const linesSpan = dom.appendChild(document.createElement("span"))
  linesSpan.textContent = currentLine(view.state)

  const fullscreenBtn = dom.appendChild(document.createElement("button"))
  fullscreenBtn.style.position = "absolute"
  fullscreenBtn.style.right = "1em"
  fullscreenBtn.innerHTML = '<i class="fa-solid fa-compress"></i>'
  fullscreenBtn.onclick = () => {
    view.focus()
  }

  return {
    dom,
    update(update) {
      if (update.docChanged)
        wordsSpan.textContent = countWords(update.view.state.doc)
      if (update.selectionSet)
        linesSpan.textContent = currentLine(update.view.state)
    },
  };
}

export default function WordStatPanel(): Extension {
  return showPanel.of(wordStatPanel);
}
