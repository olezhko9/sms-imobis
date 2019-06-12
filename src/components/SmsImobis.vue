<template>
  <div class="row justify-content-center">
    <div class="col-8">
      <form>
        <div class="form-row">
          <textarea class="form-control" rows="5" v-model="smsText" @input="updateSmsInfo"></textarea>
        </div>
        <div class="form-row text-left mt-3">
          <div class="form-group col-12 col-sm-8 col-lg-6 text-left">
            <label class="switch">
              <input type="checkbox" v-model="showTranslit" @click="transliterateSmsText">
              <span class="slider round"></span>
            </label>Транслитерировать
          </div>
          <div class="form-group col-12 col-sm-4 col-lg-4">
            <span>Символов: {{ smsTextLength }} ({{ smsCount }})</span>
          </div>
          <div class="form-group col-12 col-lg-2 text-right">
            <input type="button" value="Сохранить" class="btn btn-primary btn-sm btn-block" @click="saveSms">
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import SmsService from "@/services/SmsService"

export default {
  name: 'SmsImobis',
  data() {
    return {
      smsText: '',
      smsOriginalText: '',
      smsTransliteratedText: '',
      smsTextLength: 0,
      smsCount: 0,
      showTranslit: false
    }
  },

  methods: {
    updateSmsInfo() {
      this.getSmsTextLength();
      this.getSmsCount();
    },

    getSmsTextLength() {
      this.smsTextLength = this.smsText.length;
    },

    getSmsCount() {
      let segmentLength, shortenedSegmentLength;
      if (this.containsOnlyGSM()) {
        segmentLength = 160;
        shortenedSegmentLength = 153;
      } else {
        segmentLength = 70;
        shortenedSegmentLength = 67;
      }

      if (this.smsTextLength === 0) this.smsCount = 0;
      else if (this.smsTextLength <= segmentLength) this.smsCount = 1;
      else this.smsCount = Math.ceil(this.smsTextLength / shortenedSegmentLength);
    },

    containsOnlyGSM() {
      // GSM 7-bit alphabet from https://messente.com/blog/most-recent/how-is-sms-length-calculated
      const GSMCharacters = "@£$¥èéùìòÇØø\nÅåΔ_ΦΓΛΩΠΨΣΘΞ'ÆæßÉ !\"#¤%&()*=,-./0123456789:;<=>?¡ABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÑÜ¿abcdefghijklmnopqrstuvwxyzäöñüà";
      const GSMExtendedCharacters = "|^€{}[]~\\";
      for (let char of this.smsText) {
        if (GSMCharacters.indexOf(char) < 0 && GSMExtendedCharacters.indexOf(char) < 0) return false;
      }
      return true;
    },

    transliterateSmsText() {
      const translit = {
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh', 'з': 'z', 'и': 'i',
        'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u',
        'ф': 'f', 'х': 'h', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 'щ': 'sch', 'ъ': '\'', 'ы': 'i', 'ь': '\'', 'э': 'e',
        'ю': 'u', 'я': 'ya', '«': '"', '»': '"', '–': '-', '—': '-', '№': '#', '`': '\''
      };

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

      this.updateSmsInfo();
    },

    saveSms() {
      let formData = new FormData();
      formData.append('sms_text', this.smsText);
      formData.append('sms_count', this.smsCount);
      SmsService.saveSms(formData)
        .then(res => {
          console.log(res);
          this.smsText = '';
          this.getSmsTextLength();
        })
        .catch(err => {
          console.log(err);
        });
    },
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
