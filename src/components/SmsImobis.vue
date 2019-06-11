<template>
  <div class="sms">
    <form action="">
      <div class="form-row">
        <textarea class="form-control" rows="5" v-model="smsText" @input="getSmsTextLength"></textarea>
      </div>
      <div class="form-row mt-3">
        <div class="form-group col-md-4 justify-content-start">
          <label class="switch">
            <input type="checkbox" v-model="showTranslit" @click="transliterateSmsText">
            <span class="slider round"></span>
          </label>Транслитерировать
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
      smsOriginalText: '',
      smsTransliteratedText: '',
      smsTextLength: 0,
      showTranslit: false
    }
  },

  methods: {
    getSmsTextLength() {
      this.smsTextLength = this.smsText.length;
    },

    transliterateSmsText() {
      let translit = {
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh', 'з': 'z', 'и': 'i',
        'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u',
        'ф': 'f', 'х': 'h', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 'щ': 'sch', 'ъ': '\'', 'ы': 'i', 'ь': '\'', 'э': 'e',
        'ю': 'u', 'я': 'ya', '«': '"', '»': '"', '–': '-', '—': '-', '№': '#', '`': '\''
      }

      function capitalize(str) {
        return str[0].toUpperCase() + str.slice(1);
      }

      if (!this.showTranslit) {
        this.smsOriginalText = this.smsText;
        for (let char of this.smsText) {
          if (char.toLowerCase() in translit) {
            if (char === char.toUpperCase()) {
              this.smsTransliteratedText += capitalize(translit[char.toLowerCase()]);
            } else {
              this.smsTransliteratedText += translit[char];
            }
          } else {
            this.smsTransliteratedText += char;
          }
        }
        this.smsText = this.smsTransliteratedText;
      } else {
        this.smsText = this.smsOriginalText;
        this.smsTransliteratedText = '';
      }

      this.getSmsTextLength();
    }
  }
}
</script>

<style scoped>
  .switch {
    position: relative;
    display: inline-block;
    width: 48px;
    height: 26px;
    margin-right: 10px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked + .slider {
    background-color: #2196F3;
  }

  input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked + .slider:before {
    -webkit-transform: translateX(22px);
    -ms-transform: translateX(22px);
    transform: translateX(22px);
  }

  .slider.round {
    border-radius: 26px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
</style>
