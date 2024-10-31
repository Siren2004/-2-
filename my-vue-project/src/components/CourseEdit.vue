<template>
    <Header />
    <div>
        <form @submit.prevent="saveCourse" style="margin-left: 450px;">
            <input type="hidden" name="id_direction" v-model="direction.id_direction">
            <input placeholder="Название направления" type="text" v-model="direction.name_direction" name="name_direction" class="form-control rounded-pill" style="width:700px;margin-bottom:25px;">
            <button type="submit" class="btn btn-success" style="margin-right:650px;">Сохранить</button>
        </form>
        <router-link to="/Course"><button type="submit" class="btn btn-success" style="margin-right:850px;">Вернуться</button></router-link>
    </div>
    <Footer />
</template>
  
<script>
  import Footer from "@/components/Footer.vue";
  import Header from "@/components/Header.vue";

  export default {
    name: "CourseEdit",
    props: {
      msg: String,
    },
    components: {
      Footer,
      Header,
    },
    data() {
      return {
        direction: {
        name_direction: '',
        id_direction: '',
        }
      };
    },
    created() {
      this.direction.id_direction = this.$route.params.id_direction;
    },
    methods: {
      async saveCourse() {
      const { id_direction, name_direction } = this.direction;
      const updatedData = {
        id_direction,
        name_direction,
      };

      try {
        const response = await fetch(`http://localhost/index.php/CourseEdit/${this.$route.params.id_direction}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(updatedData)
        });

        if (response.ok) {
          console.log('Course data updated successfully');
          // Добавить обработку успешного обновления
          this.$router.push('/Course');
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
  