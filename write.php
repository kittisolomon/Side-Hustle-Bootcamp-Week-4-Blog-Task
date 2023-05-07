<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>write post</title>
  </head>
  <body>
    <h2>write post</h2>
    <form id="myForm" enctype="multipart/form-data">
  <label for="blog_title">Title:</label>
  <br>
  <input type="text" id="blog_title" name="blog_title" required>
  <br><br>
 
  <label for="body">Body:</label>
  <br>
  <input type="text" id="value" name="value" required>
  <br><br>
  <label for="tags">Tags:</label>
  <br>
  <input type="text" id="tags" name="tags" required>
  <br><br>
  <label for="date_publish">Publish Date:</label>
  <br>
  <input type="date" id="date_publish" name="date_publish" required>
<br><br>
<label for="cover_picture"> Picture:</label>
  <br>
  <input type="file" id="picture" name="picture" accept="image/*" required>
  <br><br>
  
  <button type="submit">Upload Song</button>
</form>



<script>
const form = document.querySelector('#myForm');

form.addEventListener('submit', (event) => {
  event.preventDefault();

  const formData = new FormData();
  formData.append('blog_title', form.elements.blog_title.value);
  formData.append('value', form.elements.value.value);
  formData.append('tags', form.elements.tags.value);
  formData.append('date_publish', form.elements.date_publish.value);
 

  const pictureFile = form.elements.picture.files[0];
  if (pictureFile) {
    formData.append('picture', pictureFile);
  }
 console.log([...formData.entries()]);

  fetch('write_post1.php', {
    method: 'POST',
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        console.log(data.message);
      } else if(data.status === 'error') {
        console.log(data.message);
      }
    })
    .catch(error => {
      console.error(error);
    });
});

</script>
  </body>
</html>
