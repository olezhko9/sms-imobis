<template>
  <div class="sms">
    <form action="">
      <div class="form-row">
        <textarea class="form-control" rows="5" v-model="smsText" @input="getSmsTextLength"></textarea>
      </div>
      <div class="form-row mt-3">
        <div class="form-group col-md-4 justify-content-start">
          <label class="form-check-label">
            <input type="checkbox" class="form-check-input" value="">Транслитерировать
          </label>
        </div>
        <div class="form-group col-md-8 text-right">
          <span>Символов: {{ smsTextLength }}</span>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'SmsImobis',
  data() {
    return {
      smsText: '',
      smsTextLength: 0
    }
  },

  methods: {
    getSmsTextLength() {
      this.smsTextLength = this.smsText.length;
    }
  }
}
</script>

<style scoped>

</style>
