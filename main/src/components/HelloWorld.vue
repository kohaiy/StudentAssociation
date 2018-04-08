<template>
  <div class="hello">
    <span>{{msg}}</span>
    <!--<form action="http://localhost:3000/upload" method="post" enctype="multipart/form-data">-->
    <input @change="fileChange($event)" type="file" name="file"/>
    <div>{{progress}}</div>
    <input @click="submitForm" type="button" value="ok"/>
    <!--</form>-->
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'HelloWorld',
  data() {
    return {
      msg: 'Welcome to Your Vue.js App',
      file: null,
      progress: '',
    };
  },
  methods: {
    fileChange(e) {
      console.log(e.target.files[0]);
      this.file = e.target.files[0];
    },
    submitForm() {
      const data = new FormData();
      data.append('file', this.file);
      const config = {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
        onUploadProgress(progressEvent) {
          console.log(progressEvent);
          this.progress = `${(progressEvent.loaded / progressEvent.total) * 100 || 0}%`;
          console.log(this.progress);
        },
      };
      axios.post('http://localhost:3000/upload', data, config)
        .then((res) => {
          console.log(res);
        });
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

a {
  color: #42b983;
}
</style>
