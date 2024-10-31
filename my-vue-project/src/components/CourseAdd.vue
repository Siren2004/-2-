<template>
    <Header />
    <div>
      <form style="margin-left: 450px;" @submit.prevent="saveCourse">    
        <input v-model="name_direction" placeholder="Название направления" type="text" name="name_direction" class="form-control rounded-pill" style="width:700px;margin-bottom:25px;">
        <button type="submit" class="btn btn-success" style="margin-right:650px;">Сохранить</button>
      </form>
      <router-link to="/Course">
        <button type="submit" class="btn btn-success" style="margin-right:850px;">Вернуться</button>
      </router-link>
    </div>
    <Footer />
  </template>
  
  <script>
  import Footer from "@/components/Footer.vue";
  import Header from "@/components/Header.vue";
  
  export default {
    name: "CourseAdd",
    props: {
      msg: String,
    },
    components: {
      Footer,
      Header,
    },
    data() {
      return {
        name_direction: '',
      };
    },
    methods: {
      async saveCourse() {
        const courseData = {
          name_direction: this.name_direction,
    };
    
    try {
      const response = await fetch('http://localhost/index.php/CourseAdd',{
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(courseData)
      });

      if (response.ok){
        console.log('Course added successfully');
        // Добавить обработку успешного добавления
        this.$router.push('/Course');
      } else {
        console.error('Error adding student');
      }
    } catch (error) {
      console.error('Error:', error);
    }
    }
  }
};
</script>
  
  <style scoped>
    h3 {
      margin: 40px 0 0;
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