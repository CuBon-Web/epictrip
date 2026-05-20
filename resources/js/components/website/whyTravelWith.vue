<template>
  <div>
    <h3 class="page-title">Why travel with</h3>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div
              class="why-item"
              v-for="(item, key) in objData"
              :key="'why-travel-' + key"
            >
              <div class="why-item__head">
                <h5>Mục {{ key + 1 }}</h5>
                <button
                  v-if="objData.length > 1"
                  type="button"
                  class="why-remove"
                  title="Xóa mục"
                  @click="removeItem(key)"
                >
                  <vs-icon icon="clear"></vs-icon>
                </button>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <image-upload
                      type="avatar"
                      v-model="item.image"
                      :title="'why-travel-'"
                    ></image-upload>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <multi-lang-field
                      v-model="item.title"
                      :languages="lang"
                      type="text"
                      label="Tiêu đề"
                      placeholder="Tiêu đề"
                    />
                  </div>
                  <div class="form-group">
                    <multi-lang-field
                      v-model="item.description"
                      :languages="lang"
                      type="textarea"
                      label="Mô tả ngắn"
                      placeholder="Mô tả ngắn"
                    />
                  </div>
                  <div class="form-group">
                    <label>Trạng thái</label>
                    <vs-select v-model="item.status">
                      <vs-select-item value="1" text="Hiện" />
                      <vs-select-item value="0" text="Ẩn" />
                    </vs-select>
                  </div>
                </div>
              </div>
            </div>

            <vs-button color="primary" @click="saveItems">Lưu</vs-button>
            <vs-button color="success" @click="addItem">Thêm mục</vs-button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  name: "whyTravelWith",
  data() {
    return {
      lang: [],
      objData: [],
    };
  },
  methods: {
    ...mapActions([
      "saveWhyTravelWith",
      "loadings",
      "listWhyTravelWith",
      "listLanguage",
    ]),
    createTranslatable(value = "") {
      const langs =
        this.lang && this.lang.length
          ? this.lang
          : [{ code: "en-US" }, { code: "es-ES" }];

      return langs.map((item, index) => ({
        lang_code:
          item.code || item.lang_code || (index === 0 ? "en-US" : "es-ES"),
        content: index === 0 ? value : "",
      }));
    },
    parseTranslatable(value) {
      if (Array.isArray(value)) {
        return this.fillMissingLanguages(value);
      }

      if (typeof value === "string" && value !== "") {
        try {
          const parsed = JSON.parse(value);
          if (Array.isArray(parsed)) {
            return this.fillMissingLanguages(parsed);
          }
        } catch (e) {
          return this.createTranslatable(value);
        }
      }

      return this.createTranslatable("");
    },
    fillMissingLanguages(value) {
      const normalized = value.map((item) => ({
        lang_code: item.lang_code || item.code || "en-US",
        content: item.content || "",
      }));

      (this.lang || []).forEach((langItem) => {
        const code = langItem.code || langItem.lang_code;
        if (code && !normalized.some((item) => item.lang_code === code)) {
          normalized.push({ lang_code: code, content: "" });
        }
      });

      return normalized.length ? normalized : this.createTranslatable("");
    },
    createItem(data = {}) {
      return {
        image: data.image || "",
        status: String(data.status != null ? data.status : 1),
        sort_order: data.sort_order != null ? data.sort_order : 0,
        title: this.parseTranslatable(data.title || ""),
        description: this.parseTranslatable(data.description || ""),
      };
    },
    normalizePayload() {
      return {
        data: this.objData.map((item, index) => ({
          image: item.image || "",
          status: parseInt(item.status, 10),
          sort_order: index,
          title: this.fillMissingLanguages(item.title || []),
          description: this.fillMissingLanguages(item.description || []),
        })),
      };
    },
    saveItems() {
      this.loadings(true);
      this.saveWhyTravelWith(this.normalizePayload())
        .then(() => {
          this.loadings(false);
          this.$success("Lưu thành công");
          this.fetchList();
        })
        .catch(() => {
          this.loadings(false);
          this.$error("Lưu thất bại");
        });
    },
    addItem() {
      this.objData.push(this.createItem());
    },
    removeItem(i) {
      this.objData.splice(i, 1);
    },
    listLang() {
      return this.listLanguage().then((response) => {
        this.lang = response.data || [];
      });
    },
    fetchList() {
      this.loadings(true);
      this.listWhyTravelWith()
        .then((response) => {
          const items = response.data || [];
          this.objData = items.length
            ? items.map((item) => this.createItem(item))
            : [this.createItem()];
          this.loadings(false);
        })
        .catch(() => {
          this.loadings(false);
        });
    },
  },
  mounted() {
    this.loadings(true);
    this.listLang()
      .catch(() => {})
      .then(() => this.fetchList());
  },
};
</script>

<style scoped>
.why-item {
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  padding: 18px;
  margin-bottom: 20px;
}
.why-item__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
}
.why-item__head h5 {
  margin: 0;
  font-weight: 600;
}
.why-remove {
  border: none;
  background: transparent;
  cursor: pointer;
  color: #e74c3c;
}
</style>
