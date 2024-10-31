<template>
  <Header />
  <div>
    <form style="margin-left: 450px;" @submit.prevent="saveStudent">
      <input type="file" name="img_student" accept="image/*" v-on:change="handleFileUpload" style="width:700px;margin-bottom:25px;">
      <input v-model="name_student" placeholder="ФИО студента" type="text" name="name_student" class="form-control rounded-pill" style="width:700px;margin-bottom:25px;">
      <input v-model="course_direction" placeholder="Направление подготовки" type="text" name="course_direction" class="form-control rounded-pill" style="width:700px;margin-bottom:25px;">
      <input v-model="name_group" placeholder="Имя группы" type="text" name="name_group" class="form-control rounded-pill" style="width:700px;margin-bottom:25px;">
      <input v-model="year" placeholder="Год рождения" type="text" name="year" class="form-control rounded-pill" style="width:700px;margin-bottom:25px;">
      <button type="submit" class="btn btn-success" style="margin-right:650px;">Сохранить</button>
    </form>
    <router-link to="/Student">
      <button type="submit" class="btn btn-success" style="margin-right:850px;">Вернуться</button>
    </router-link>
  </div>
  <Footer />
</template>

<script>
import Footer from "@/components/Footer.vue";
import Header from "@/components/Header.vue";

export default {
  name: "StudentAdd",
  props: {
    msg: String,
  },
  components: {
    Footer,
    Header,
  },
  data() {
    return {
      img_student: '',
      name_student: '',
      course_direction: '',
      name_group: '',
      year: '',
    };
  },
  methods: {
  async saveStudent() {
    const studentData = {
      img_student: this.img_student,
      name_student: this.name_student,
      course_direction: this.course_direction,
      name_group: this.name_group,
      year: this.year
    };

    try {
      const response = await fetch('http://localhost/', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(studentData)
      });

      if (response.ok) {
        console.log('Student added successfully');
        // Добавить обработку успешного добавления
        this.$router.push('/Student');
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