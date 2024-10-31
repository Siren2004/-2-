<template>
    <Header />
    <div>
        <form @submit.prevent="saveStudent" style="margin-left: 450px;">
          <input type="hidden" name="id" v-model="student.id">
          <input type="file" name="img_student" accept="image/*" v-on:change="handleFileUpload" style="width:700px;margin-bottom:25px;">
          <input placeholder="ФИО студента" type="text" name="name_student" v-model="student.name_student" class="form-control rounded-pill" style="width:700px;margin-bottom:25px;">
          <input placeholder="Направление подготовки" type="text" name="course_direction" v-model="student.course_direction" class="form-control rounded-pill" style="width:700px;margin-bottom:25px;">
          <input placeholder="Имя группы" type="text" name="name_group" v-model="student.name_group" class="form-control rounded-pill" style="width:700px;margin-bottom:25px;">
          <input placeholder="Год рождения" type="text" name="year" v-model="student.year" class="form-control rounded-pill" style="width:700px;margin-bottom:25px;">  
          <button type="submit" class="btn btn-success" style="margin-right:650px;">Сохранить</button>
        </form>
        <router-link to="/Student"><button type="submit" class="btn btn-success" style="margin-right:850px;">Вернуться</button></router-link>
    </div>
    <Footer />
</template>
  
<script>
  import Footer from "@/components/Footer.vue";
  import Header from "@/components/Header.vue";

  export default {
  name: "StudentEdit",
  props: {
    msg: String,
  },
  data() {
    return {
      student: {
        id: '',
        img_student: '',
        name_student: '',
        course_direction: '',
        name_group: '',
        year: ''
      }
    };
  },
  created() {
    this.student.id = this.$route.params.id;
  },
  components: {
    Footer,
    Header,
  },
  methods: {
    async saveStudent() {
      const { id, img_student, name_student, course_direction, name_group, year } = this.student;
      const updatedData = {
        id,
        img_student,
        name_student,
        course_direction,
        name_group,
        year
      };

      try {
        const response = await fetch(`http://localhost/index.php/${this.$route.params.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(updatedData)
        });

        if (response.ok) {
          console.log('Student data updated successfully');
          // Добавить обработку успешного обновления
          this.$router.push('/Student');
        } else {
          console.error('Error updating student data');
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
  