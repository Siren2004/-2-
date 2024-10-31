<template>   
    <main class="container" style="margin-top: 400px;">
        <div class="bg-light p-5 rounded d-flex flex-column align-items-start">
            <h1>Подвал</h1>
            <p class="lead">Подвальный текст.</p>
            <a class="btn btn-lg btn-primary" href="https://getbootstrap.com/docs/5.1/components/navbar/" role="button">Подвальная кнопка »</a>
        </div>
    </main> 
</template>

<script>
export default {
    name: 'FooterSection',
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