<template>
  <div>
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <h4 class="card-title">Thêm mới tags</h4>
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
                <label>Danh mục tag</label>
                <vs-select class="selectExample" v-model="objData.cate_tag_id" placeholder="Danh mục">
                  <vs-select-item :value="0" text="Danh mục tag" />
                  <vs-select-item
                    v-for="(item, index) in categoryList"
                    :key="'f' + index"
                    :value="item.id"
                    :text="formatCateText(item)"
                  />
                </vs-select>
              </div>
              <div class="form-group">
                <multi-lang-field
                  v-model="objData.content"
                  :languages="lang"
                  type="tinymce"
                  label="Nội dung"
                  placeholder="Nội dung"
                />
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
        name: [
          { lang_code: "en-US", content: "" }
        ],
        status: 1,
        cate_tag_id: "",
        image: "",
        content: [
          { lang_code: "en-US", content: "" }
        ],
        cate_product_id: "",
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
    listCatePro() {
      this.loadings(true);
      this.listCate().then(response => {
        this.loadings(false);
        this.categoryPro = response.data;
      });
    },
    listCategory() {
      this.loadings(true);
      this.listTagCate().then(response => {
        this.loadings(false);
        this.categoryList = response.data;
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
          this.$success("Thêm tags thành công");
          this.$router.push({ name: "list_tag" });
        })
        .catch(() => {
          this.loadings(false);
          this.$error("Thêm tags thất bại");
        });
    },
    listLang() {
      this.listLanguage()
        .then(response => {
          this.loadings(false);
          this.lang = response.data || [];
        })
        .catch(() => {});
    }
  },
  mounted() {
    this.loadings(true);
    this.listLang();
    this.listCategory();
    this.listCatePro();
  }
};
</script>

<style>
</style>
