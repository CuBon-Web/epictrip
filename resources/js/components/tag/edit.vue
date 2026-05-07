<template>
  <div>
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <h4 class="card-title">Sửa tag</h4>
              </div>
            </div>

            <form class="forms-sample">
              <div class="form-group">
                <multi-lang-field
                  v-model="objData.name"
                  :languages="lang"
                  type="text"
                  label="Tên tag"
                  placeholder="Tên tag"
                />
              </div>

              <div class="form-group">
                <label>Danh mục cha</label>
                <vs-select class="selectExample" v-model="objData.cate_tag_id" placeholder="Danh mục">
                  <vs-select-item :value="0" text="Danh mục cha" />
                  <vs-select-item
                    v-for="(item, index) in categoryList"
                    :key="'f' + index"
                    :value="item.id"
                    :text="formatCateText(item)"
                  />
                </vs-select>
              </div>

              <div class="form-group">
                <label>Ảnh bìa</label>
                <image-upload
                  v-model="objData.image"
                  type="avatar"
                  :title="'tag'"
                ></image-upload>
              </div>

              <div class="form-group">
                <label>Trạng thái</label>
                <vs-select v-model="objData.status">
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
        id: this.$route.params.id,
        name: [
          { lang_code: "en-US", content: "" }
        ],
        status: 1,
        cate_tag_id: "",
        cate_product_id: "",
        image: ""
      },
      categoryList: [],
      categoryPro: [],
      lang: [],
      submitted: false,
      errors: []
    };
  },
  methods: {
    ...mapActions([
      "getInfoTag",
      "saveTag",
      "listLanguage",
      "loadings",
      "listTagCate",
      "listCate"
    ]),
    parseLang(value) {
      if (Array.isArray(value)) {
        const first = value.find(item => (item.content || "").trim() !== "");
        return first ? first.content : "";
      }
      try {
        const parsed = JSON.parse(value);
        if (Array.isArray(parsed)) {
          const first = parsed.find(item => (item.content || "").trim() !== "");
          return first ? first.content : "";
        }
      } catch (e) {}
      return value || "";
    },
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
    formatCateText(item) {
      const tagCateName = this.parseLang(item.name);
      if (item.cate_product != null) {
        const cateProName = this.parseLang(item.cate_product.name);
        return `${tagCateName} (${cateProName})`;
      }
      return `${tagCateName} (không thuộc danh mục nào)`;
    },
    getNameContent(name) {
      if (Array.isArray(name)) {
        const first = name.find(item => (item.content || "").trim() !== "");
        return first ? first.content : "";
      }
      return name || "";
    },
    listCategory() {
      this.loadings(true);
      this.listTagCate().then(response => {
        this.loadings(false);
        this.categoryList = response.data;
      });
    },
    listCatePro() {
      this.loadings(true);
      this.listCate().then(response => {
        this.loadings(false);
        this.categoryPro = response.data;
      });
    },
    saveEdit() {
      this.errors = [];
      if (!this.getNameContent(this.objData.name)) {
        this.errors.push("Tên tag không được để trống");
      }
      if (this.objData.cate_tag_id === "" || this.objData.cate_tag_id === null) {
        this.errors.push("Danh mục tags không được để trống");
      }
      if (this.errors.length > 0) {
        this.errors.forEach(value => this.$error(value));
        return;
      }

      this.loadings(true);
      this.saveTag(this.objData)
        .then(() => {
          this.loadings(false);
          this.$success("Sửa tag thành công");
          this.$router.push({ name: "list_tag" });
        })
        .catch(() => {
          this.loadings(false);
          this.$error("Sửa thất bại");
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
      this.getInfoTag(this.objData)
        .then(response => {
          this.loadings(false);
          if (response.data == null) {
            this.objData = {
              id: this.$route.params.id,
              name: [{ lang_code: "en-US", content: "" }],
              status: 1,
              cate_tag_id: "",
              cate_product_id: "",
              image: ""
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
    this.listCategory();
    this.listCatePro();
  }
};
</script>

<style>
</style>
