import {AxiosError, AxiosResponse} from "axios";

export default function uploadBlogImg(id: number, img: File) {
  const data = {
    "id": id,
    "img": img,
  };

  window.axios.post('/api/blog/img', data, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  })
    .then(function (response: AxiosResponse) {
      const newImg = document.createElement('div');
      newImg.classList.add("blog-edit-img");
      newImg.style.backgroundImage = `url(/storage/${response.data.path})`;
      imgContainer.prepend(newImg);
    })
    .catch(function (error: AxiosError) {
      console.log(`Image upload failure: [data=${data}], [error=${error}]`);
    });
}

const id = +(document.getElementById("id") as HTMLInputElement).value;

const imgContainer = document.getElementById("imgContainer");
const imgInput = document.getElementById("img") as HTMLInputElement;
imgInput.onchange = function () {
  const inputFile = imgInput.files[0];
  if (!inputFile) return;
  uploadBlogImg(id, imgInput.files[0]);
}
