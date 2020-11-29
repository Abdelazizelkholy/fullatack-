<template>
  <div>
    <h1>
      the number is : {{ views }}
    </h1>
    <button @click="updateCounter(1)"> increase</button>
    <button @click="updateCounter(-1)"> decrease</button>
    <br><br>
    <div v-for="(blog , i) in blogs" v-if="blogs.length">
      <h3> {{ blog.title }} </h3>
      <p> {{ blog.post }} </p>
    </div>
    <br><br><br>
    <div>
      <h1 v-if="showItem"> show if showItem is true </h1>
      <h1 v-else> show if showItem is false </h1>
    </div>
    <button @click="showItem=!showItem "> change</button>
  </div>
</template>
<script>
export default {
  data() {
    return {
      views: 0,
      blogs: [],
      showItem: false,
    }
  },
  //  methods
  methods: {
    updateCounter: function (number) {
      this.views += number
    }
  },
  created() {
    // call the server to get views blog post
    this.views = 100
    // get the blog posts
    let posts = [
      {id: 1, title: 'the blog title 1', post: 'the blog post 1'},
      {id: 2, title: 'the blog title 2', post: 'the blog post 2'},
      {id: 3, title: 'the blog title 3', post: 'the blog post 3'},
      {id: 4, title: 'the blog title 4', post: 'the blog post 4'},
      {id: 5, title: 'the blog title 5', post: 'the blog post 5'}
    ]
    this.blogs = posts
  }
}
</script>