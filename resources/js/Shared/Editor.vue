<template>
<!--  <div id="app">-->
<!--    <img alt="Vue logo" src="./img/logo.png">-->
    <editor
        api-key="aq4yxpek36fz7epa0kqorg4304hgfjrk8qqwtf0binzc8iw6"
        :init="{
         height: 500,
         width: 1134,
         menubar: true,
         plugins: [
           'advlist autolink lists link image charmap print preview hr anchor pagebreak',
           'searchreplace wordcount visualblocks visualchars code fullscreen',
           'insertdatetime media nonbreaking save table directionality',
           'emoticons template paste textpattern',
         ],
         toolbar:
           'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media',

       }"
    />
<!--  </div>-->
</template>

<script>
import Editor from '@tinymce/tinymce-vue'

export default {
  components: {
    'editor': Editor
  }
}
</script>

<style scoped>

</style>