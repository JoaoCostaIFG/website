import {AxiosError, AxiosResponse} from "axios";

function createImage(id: number, fileName: string): HTMLElement {
  const newImg = document.createElement('div');
  newImg.classList.add("blog-edit-img");
  const url = `/storage/blogs/${id}/${fileName}`;
  newImg.style.backgroundImage = `url(${url})`;
  newImg.onclick = () => {navigator.clipboard.writeText(url)};

  const rmBtn = newImg.appendChild(document.createElement('button'));
  rmBtn.classList.add('absolute', '-right-2', '-top-1', 'icon-btn-sm', 'btn-danger', 'z-10');
  rmBtn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
  rmBtn.onclick = () => {
    window.axios.delete(route('api-img_delete', [id, fileName]))
      .then(function (response: AxiosResponse) {
        newImg.remove();
      })
      .catch(function (error: AxiosError) {
        console.log(`Image delete failure: [id=${id}], [fileName=${fileName}], [error=${error}].`);
      });
  };

  return newImg;
}

function uploadBlogImg(id: number, img: File) {
  const data = {
    "id": id,
    "img": img,
  };

  window.axios.post(route('api-img'), data, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  })
    .then(function (response: AxiosResponse) {
      imgContainer.prepend(createImage(id, response.data.path));
    })
    .catch(function (error: AxiosError) {
      console.log(`Image upload failure: [data=${data}], [error=${error}].`);
    });
}

const id = +(document.getElementById("id") as HTMLInputElement).value;

const imgContainer = document.getElementById("imgContainer");
const imgInput = document.getElementById("img") as HTMLInputElement;
imgInput.onchange = () => {
  const inputFile = imgInput.files[0];
  if (!inputFile) return;
  uploadBlogImg(id, imgInput.files[0]);
}

// load existing images
window.axios.get(route('api-img_list', id))
  .then(function (response: AxiosResponse) {
    response.data.files.forEach((imgFile: string) => {
      imgContainer.prepend(createImage(id, imgFile));
    });
  })
  .catch(function (error: AxiosError) {
    console.error(`Image list fetch failed: [error=${error}].`);
  });
