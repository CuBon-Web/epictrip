<template>
  <div>
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <h4 class="card-title">Sửa danh mục tag</h4>
              </div>
            </div>

            <form class="forms-sample">
              <div class="form-group">
                <multi-lang-field
                  v-model="objData.name"
                  :languages="lang"
                  type="text"
                  label="Tên danh mục"
                  placeholder="Tên danh mục"
                />
              </div>

              <div class="form-group">
                <label>Trạng thái hiển thị menu</label>
                <vs-select v-model="objData.status">
                  <vs-select-item value="1" text="Hiện" />
                  <vs-select-item value="0" text="Ẩn" />
                </vs-select>
              </div>

              <div class="form-group">
                <label>Trạng thái hiển thị trong bộ lọc</label>
                <vs-select v-model="objData.status_filter">
                  <vs-select-item value="1" text="Hiện" />
                  <vs-select-item value="0" text="Ẩn" />
                </vs-select>
              </div>

              <vs-button
                color="success"
                type="gradient"
                class="mr-left-45"
                @click="saveEdit()"
              >Lưu lại</vs-button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      objData: {
        language: this.$route.params.language,
        id: this.$route.params.id,
        name: [
          { lang_code: "en-US", content: "" }
        ],
        status: 1,
        cate_product_id: 0,
        status_filter: 1
      },
      lang: [],
      submitted: false,
      errors: []
    };
  },
  methods: {
    ...mapActions([
      "getInfoTagCate",
      "saveTagCate",
      "listLanguage",
      "loadings"
    ]),
    parseName(name) {
      if (Array.isArray(name)) return name;
      if (typeof name === "string" && name !== "") {
        try {
          const parsed = JSON.parse(name);
          if (Array.isArray(parsed)) return parsed;
        } catch (e) {
          return [{ lang_code: "en-US", content: name }];
        }
      }
      return [{ lang_code: "en-US", content: "" }];
    },
    getNameContent(name) {
      if (Array.isArray(name)) {
        const first = name.find(item => (item.content || "").trim() !== "");
        return first ? first.content : "";
      }
      return name || "";
    },
    saveEdit() {
      this.errors = [];
      if (!this.getNameContent(this.objData.name)) {
        this.errors.push("Tên danh mục không được để trống");
      }
      if (this.errors.length > 0) {
        this.errors.forEach(value => this.$error(value));
        return;
      }

      this.loadings(true);
      this.saveTagCate(this.objData)
        .then(() => {
          this.loadings(false);
          this.$success("Sửa danh mục tag thành công");
          this.$router.push({ name: "list_tag_cate" });
        })
        .catch(() => {
          this.loadings(false);
          this.$error("Sửa danh mục thất bại");
        });
    },
    listLang() {
      this.listLanguage()
        .then(response => {
          this.loadings(false);
          this.lang = response.data || [];
        })
        .catch(() => {});
    },
    getInfoCates() {
      this.loadings(true);
      this.getInfoTagCate(this.objData)
        .then(response => {
          this.loadings(false);
          if (response.data == null) {
            this.objData = {
              id: this.$route.params.id,
              name: [{ lang_code: "en-US", content: "" }],
              status: 1,
              cate_product_id: 0,
              status_filter: 1
            };
          } else {
            this.objData = {
              ...response.data,
              name: this.parseName(response.data.name)
            };
          }
        })
        .catch(() => {});
    },
    changeLanguage() {
      this.getInfoCates();
    }
  },
  mounted() {
    this.loadings(true);
    this.getInfoCates();
    this.listLang();
  }
};
</script>

<style>
</style>
