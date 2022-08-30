import {EditorState, Extension, Range, RangeSet, StateField} from "@codemirror/state";
import {Decoration, DecorationSet, EditorView, WidgetType} from "@codemirror/view";
import {syntaxTree} from '@codemirror/language'

interface ImageWidgetParams {
  url: string,
}

class ImageWidget extends WidgetType {
  readonly url

  constructor({url}: ImageWidgetParams) {
    super()
    this.url = url
  }

  eq(other: ImageWidget): boolean {
    return this.url == other.url
  }

  toDOM(view: EditorView): HTMLElement {
    let container = document.createElement("div");
    container.className = "cm-img-container"
    let img = container.appendChild(document.createElement("img"))
    img.className = "cm-img"
    img.src = this.url;

    return container;
  }

  /* ignore events that happen in the widget */
  ignoreEvent() {
    return true
  }
}

const imageDecoration = (params: ImageWidgetParams) => Decoration.widget({
  widget: new ImageWidget(params),
  side: 1,
  block: true,
})

function imageMatch(state: EditorState): RangeSet<Decoration> {
  const doc = state.doc
  let widgets: Range<Decoration>[] = []

  const regex = /!\[.*?\]\((?<url>.*?)\)/
  syntaxTree(state).iterate({
    enter: ({type, from, to}) => {
      if (type.name === "Image") {
        const result = regex.exec(doc.sliceString(from, to))
        if (result && result.groups && result.groups.url) {
          let deco = imageDecoration({url: result.groups.url})
          widgets.push(deco.range(doc.lineAt(to).to))
        }
      }
    }
  })

  return RangeSet.of(widgets)
}

const imageStateField = StateField.define<DecorationSet>({
  create(state) {
    return imageMatch(state)
  },
  update(images, tr) {
    if (tr.docChanged)
      return imageMatch(tr.state)
    return images.map(tr.changes)
  },
  provide: f => EditorView.decorations.from(f)
})

const imageTheme = EditorView.baseTheme({
  '.cm-img-container': {
    display: 'block',
    width: '100%',
    'text-align': "center",
  },
  '.cm-img': {
    display: 'block',
    'margin': '0 auto 0',
    'max-height': '24em',
    padding: '0 1em 0',
  }
})

export default function images(): Extension {
  return [imageStateField, imageTheme]
}
