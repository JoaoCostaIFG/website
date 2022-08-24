import MarkdownMirror from "./markdownmirror";

function spawnEditor() {
  const input = document.getElementById("content") as HTMLTextAreaElement
  const editorContainer = document.getElementById("editor-container")

  let mm = new MarkdownMirror({
    content: "![](https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fimages6.fanpop.com%2Fimage%2Fphotos%2F39300000%2FDog-dogs-39323649-1440-900.jpg&f=1&nofb=1)",
    parent: editorContainer,
    input: input,
  })
}

spawnEditor();

/*
 * fileUpload.addEventListener("change", e => {
 *   const target = e.target as HTMLInputElement;
 *   if (mm.view.state.selection.ranges[0].from && target.files.length > 0)
 *     console.log(target.files)
 *   mm.view.focus()
 * })
 */
