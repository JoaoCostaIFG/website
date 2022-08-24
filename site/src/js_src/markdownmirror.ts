import {EditorState} from "@codemirror/state";
import {
  EditorView, keymap, highlightSpecialChars, drawSelection, highlightActiveLine, dropCursor,
  rectangularSelection, crosshairCursor,
  lineNumbers, highlightActiveLineGutter,
} from "@codemirror/view";
import {indentWithTab, defaultKeymap, history, historyKeymap} from "@codemirror/commands";
import {searchKeymap, highlightSelectionMatches} from "@codemirror/search"
import {
  defaultHighlightStyle, syntaxHighlighting, indentOnInput, bracketMatching,
  foldGutter, foldKeymap
} from "@codemirror/language"
import {closeBrackets, closeBracketsKeymap} from "@codemirror/autocomplete"
import {vim} from "@replit/codemirror-vim";
import {markdown} from "@codemirror/lang-markdown";
import {languages} from "@codemirror/language-data";
import WordStatPanel from "./wordstatpanel";
import {oneDark} from "@codemirror/theme-one-dark";
import Clone2Input from "./clone2input";
import images from "./imagewidget";

export interface MarkdownMirrorParams {
  content?: string,
  parent: Element,
  input: HTMLTextAreaElement,
}

export default class MarkdownMirror {
  view: EditorView

  constructor({content, parent, input}: MarkdownMirrorParams) {
    let state = EditorState.create({
      doc: content,
      extensions: [
        lineNumbers(),
        highlightActiveLineGutter(),
        highlightSpecialChars(),
        history(),
        foldGutter(),
        drawSelection(),
        dropCursor(),
        EditorState.allowMultipleSelections.of(true),
        indentOnInput(),
        syntaxHighlighting(defaultHighlightStyle, {fallback: true}),
        bracketMatching(),
        closeBrackets(),
        rectangularSelection(),
        crosshairCursor(),
        highlightActiveLine(),
        highlightSelectionMatches(),
        // keymaps
        vim(), // make sure it is included before other keymaps
        keymap.of([
          ...closeBracketsKeymap,
          ...defaultKeymap,
          ...searchKeymap,
          ...historyKeymap,
          ...foldKeymap,
          indentWithTab
        ]),
        // mine
        WordStatPanel(),
        Clone2Input(input),
        images(),
        // theme
        markdown({codeLanguages: languages}),
        EditorState.tabSize.of(2),
        oneDark,
      ],
    });


    this.view = new EditorView({
      state,
      parent: parent,
    });
  }

  uploadFile(file: File): Promise<string> {
    return new Promise((resolve, reject) => {
      resolve("A string: " + file.name);
    });
  }

  uploadImg(file: File): void {
    let id = {} // fresh object to act as the ID for this upload

    /*
  
    // Replace the selection with a placeholder
    let tr = view.state.tr
    if (!tr.selection.empty) tr.deleteSelection()
    tr.setMeta(placeholderPlugin, {add: {id, pos: tr.selection.from}})
    view.dispatch(tr)
  
    this.uploadFile(file).then(url => {
      let pos = findPlaceholder(view.state, id)
      // If the content around the placeholder has been deleted, drop the image
      if (pos == null) return
      // Otherwise, insert it at the placeholder's position, and remove the placeholder
      view.dispatch(view.state.tr
        .replaceWith(pos, pos, schema.nodes.image.create({src: url}))
        .setMeta(placeholderPlugin, {remove: {id}}))
    }, () => {
      // On failure, just clean up the placeholder
      view.dispatch(tr.setMeta(placeholderPlugin, {remove: {id}}))
    })
  
    */
  }
}
