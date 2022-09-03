import {Extension} from "@codemirror/state";
import {ViewUpdate} from "@codemirror/view";
import {EditorView} from "codemirror";

function clone2Input(input: HTMLTextAreaElement): (update: ViewUpdate) => void {
  return function update(update: ViewUpdate) {
    if (update.docChanged) {
      input.textContent = update.view.state.doc.sliceString(0)
    }
  }
}

export default function Clone2Input(input: HTMLTextAreaElement): Extension {
  return EditorView.updateListener.of(clone2Input(input));
}
