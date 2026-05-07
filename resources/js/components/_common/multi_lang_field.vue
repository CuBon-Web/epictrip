<template>
  <div class="multi-lang-field">
    <label v-if="label">{{ label }}</label>

    <div class="multi-lang-field__tabs" v-if="items.length > 1">
      <button
        type="button"
        class="multi-lang-field__tab"
        v-for="(item, index) in items"
        :key="`${item.lang_code}-tab-${index}`"
        :class="{ active: activeLang === item.lang_code }"
        @click="activeLang = item.lang_code"
      >
        {{ getLanguageName(item.lang_code) }}
      </button>
    </div>

    <div class="multi-lang-field__item" v-if="activeItem">
      <div class="multi-lang-field__lang" v-if="items.length <= 1">
        {{ getLanguageName(activeItem.lang_code) }}
      </div>

      <TinyMce
        v-if="type === 'tinymce'"
        :value="activeItem.content"
        @input="updateContent(activeIndex, $event)"
      />

      <textarea
        v-else-if="type === 'textarea'"
        class="form-control"
        :placeholder="placeholder"
        :value="activeItem.content"
        @input="updateContent(activeIndex, $event.target.value)"
      ></textarea>

      <input
        v-else
        class="form-control"
        :type="type === 'number' ? 'number' : 'text'"
        :placeholder="placeholder"
        :value="activeItem.content"
        @input="updateContent(activeIndex, $event.target.value)"
      >
    </div>
  </div>
</template>

<script>
import TinyMce from "./tinymce.vue";

export default {
  name: "multi-lang-field",
  components: {
    TinyMce
  },
  data() {
    return {
      activeLang: ""
    };
  },
  props: {
    value: {
      type: [Array, String, Number],
      default: () => []
    },
    languages: {
      type: Array,
      default: () => []
    },
    type: {
      type: String,
      default: "text"
    },
    label: {
      type: String,
      default: ""
    },
    placeholder: {
      type: String,
      default: ""
    }
  },
  computed: {
    items() {
      return this.normalizeValue(this.value);
    },
    activeIndex() {
      const index = this.items.findIndex(item => item.lang_code === this.activeLang);
      return index >= 0 ? index : 0;
    },
    activeItem() {
      return this.items[this.activeIndex] || null;
    }
  },
  watch: {
    languages: {
      handler() {
        this.emitNormalized();
      },
      deep: true
    },
    items: {
      handler(items) {
        if (!items.length) return;
        if (!this.activeLang || !items.some(item => item.lang_code === this.activeLang)) {
          this.activeLang = items[0].lang_code;
        }
      },
      immediate: true
    }
  },
  mounted() {
    this.emitNormalized();
  },
  methods: {
    normalizeValue(value) {
      let rows = [];

      if (Array.isArray(value)) {
        rows = value.map(item => ({
          lang_code: item.lang_code || item.code || "en-US",
          content: item.content != null ? item.content : ""
        }));
      } else if (value !== null && value !== undefined && value !== "") {
        rows = [{
          lang_code: this.defaultLangCode(),
          content: value
        }];
      }

      const langs = this.languages && this.languages.length
        ? this.languages
        : [{ code: this.defaultLangCode() }];

      langs.forEach((lang, index) => {
        const code = lang.code || lang.lang_code || (index === 0 ? this.defaultLangCode() : "");
        if (code && !rows.some(item => item.lang_code === code)) {
          rows.push({
            lang_code: code,
            content: ""
          });
        }
      });

      return rows.length ? rows : [{ lang_code: this.defaultLangCode(), content: "" }];
    },
    defaultLangCode() {
      return "en-US";
    },
    getLanguageName(code) {
      const lang = (this.languages || []).find(item => (item.code || item.lang_code) === code);
      return lang ? (lang.name || lang.code || code) : code;
    },
    updateContent(index, content) {
      const next = this.items.map(item => ({ ...item }));
      next[index].content = content;
      this.$emit("input", next);
    },
    emitNormalized() {
      const normalized = this.items;
      if (JSON.stringify(normalized) !== JSON.stringify(this.value)) {
        this.$emit("input", normalized);
      }
    }
  }
};
</script>

<style scoped>
.multi-lang-field__tabs {
  display: flex;
  gap: 6px;
  flex-wrap: wrap;
  margin-bottom: 10px;
}

.multi-lang-field__tab {
  border: 1px solid #dbe3ef;
  border-radius: 999px;
  background: #f8fafc;
  color: #334155;
  cursor: pointer;
  font-size: 12px;
  font-weight: 600;
  padding: 5px 12px;
  transition: all .2s ease;
}

.multi-lang-field__tab.active {
  background: #3730a3;
  border-color: #3730a3;
  color: #fff;
}

.multi-lang-field__item {
  margin-bottom: 12px;
}

.multi-lang-field__lang {
  display: inline-block;
  margin-bottom: 6px;
  padding: 2px 8px;
  border-radius: 999px;
  background: #eef2ff;
  color: #3730a3;
  font-size: 12px;
  font-weight: 600;
}

.multi-lang-field textarea {
  min-height: 90px;
}
</style>
