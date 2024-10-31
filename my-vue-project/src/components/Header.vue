<template>   
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                <router-link class="nav-link active" aria-current="page" to="/Student">Студенты</router-link>
                </li>
                <li class="nav-item">
                <router-link class="nav-link" to="/Course">Направление подготовки</router-link>
                </li>
            </ul>
            
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'HeaderSection',
    props: {
      msg: String
    }
}
</script>

<style scoped>
body {
    min-height: 75rem;
}
.bd-placeholder-img {
  font-size: 1.125rem;
  text-anchor: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
}

@media (min-width: 768px) {
  .bd-placeholder-img-lg {
    font-size: 3.5rem;
  }
}
</style>