<template>
  <Header />
  <form style="margin-left: 200px;">
    <table>
      <tr>
        <th style="padding-right: 20px;">ID</th>
        <th style="padding-right: 20px;">Направление подготовки</th>
      </tr>
      <tr v-for="direction in directions" :key="direction.id_direction">
        <router-link :to="'/StudentList/' + direction.id_direction">
          <td style="padding: 20px;">{{ direction.id_direction }}</td>
        </router-link>
        <td style="padding: 20px;">{{ direction.name_direction }}</td>
        <td>
          <router-link :to="'/CourseEdit/' + direction.id_direction">
            <button type="button" class="btn btn-primary">
              Изменить
            </button>
          </router-link>
          <button type="button" @click="deleteDirection(direction.id_direction)" class="btn btn-danger">Удалить</button>
        </td>
      </tr>
    </table>
    <router-link to="/CourseAdd"><button type="button" class="btn btn-success" style="margin-left: 400px;">Добавить</button></router-link>
  </form>
  <Footer />
</template>

<script>
import Footer from "@/components/Footer.vue";
import Header from "@/components/Header.vue";

export default {
    name: 'StudentDetails',
    props: {
      msg: String
    },
    components: {
    Footer,
    Header,
  },
  data() {
    return {
      directions: [],
    };
  },
  mounted(){
    this.getDataCourse();
  },
  methods: {
    async getDataCourse() {
      try {
        const response = await fetch('http://localhost/index.php/course');
        const directionsData = await response.json();
        
        this.directions = directionsData;
      } catch (error) {
        console.error('Error:', error);
      }
    },
    async deleteDirection(id_direction) {
    try {
      const url = `http://localhost/index.php/course/${id_direction}`;
      console.log("DELETE request to URL:", url);
      
      const response = await fetch(url, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json'
        }
      });

      if (response.ok) {
        this.directions = this.directions.filter(direction => direction.id_direction !== id_direction);
      } else {
        console.error('Error deleting student');
      }
    } catch (error) {
      console.error('Error:', error);
    }
  },
  async updateDirection(id_direction, updatedData) {
      try {
        const response = await fetch(`http://localhost/course/${id_direction}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(updatedData)
        });

        if (response.ok) {
          console.log('Student data updated successfully');
          // Обновить данные о студенте на фронтенде
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
