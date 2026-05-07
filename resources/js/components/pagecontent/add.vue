<template>
  <div>
      <h3 class="page-title">Thêm mới trang nội dung</h3>
      <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <multi-lang-field
                  v-model="objData.title"
                  :languages="lang"
                  type="text"
                  label="Tên trang nội dung"
                  placeholder="Tên bài viết"
                />
                <div v-if="submitted && !hasLangContent(objData.title)" class="noti-err">Title không để trống</div>
              </div>
              <div class="form-group">
                <multi-lang-field
                  v-model="objData.content"
                  :languages="lang"
                  type="tinymce"
                  label="Nội dung"
                />
                <div v-if="submitted && !hasLangContent(objData.content)" class="noti-err">Nội dung không để trống</div>
              </div>
              <div class="form-group">
                <multi-lang-field
                  v-model="objData.description"
                  :languages="lang"
                  type="tinymce"
                  label="Mô tả ngắn"
                />
                <div v-if="submitted && !hasLangContent(objData.description)" class="noti-err">Nội dung không để trống</div>
              </div>
              <div class="form-group">
                <label>Ảnh đại diện</label>
                <image-upload
                  v-model="objData.image"
                  type="avatar"
                  :title="'trang-noi-dung'"
                ></image-upload>
              </div>
              <vs-button color="primary" @click="addPagecontent">Thêm mới</vs-button>
            </div>
          </div>
          
        </div>
        <div class="col-md-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label>Trạng thái</label>
                <vs-select v-model="objData.status"
                  >
                      <vs-select-item  value="1" text="Hiện" />
                      <vs-select-item  value="0" text="Ẩn" />
                    </vs-select>
              </div>
              <div class="form-group">
                <label>Danh mục</label>
                <vs-select v-model="objData.type"
                  >
                      <vs-select-item  value="ve-chung-toi" text="Về Chúng Tôi" />  
                      <vs-select-item  value="ho-tro-khanh-hang" text="Hỗ trợ khách hàng" />   
                    </vs-select>
              </div>
              <!-- <div class="form-group">
                <label>Danh muc</label>
                <vs-select class="selectExample" v-model="objData.category" placeholder="Danh mục">
                  <vs-select-item
                    :value="item.id"
                    :text="item.name"
                    v-for="(item,index) in cate"
                    :key="'f'+index"
                  />
                </vs-select>
                <div v-if="submitted && !$v.objData.category.required" class="noti-err">Chọn tối thiểu 1 ảnh</div>
              </div> -->
              
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
  name: "product",
  data() {
    return {
      submitted: false,
      lang: [],
      errors: [],
      cate:[],
      objData: {
        title: [{ lang_code: "en-US", content: "" }],
        content: [{ lang_code: "en-US", content: "" }],
        description: [{ lang_code: "en-US", content: "" }],
        status: 1,
        image:"",
        type:'ve-chung-toi'
      }
    };
  },
  components: {},
  computed: {},
  watch: {},
  methods: {
    ...mapActions(["savePageContent", "loadings", "listLanguage"]),
    createMultilangValue(defaultContent = "") {
      const sourceLangs = (this.lang && this.lang.length)
        ? this.lang
        : [{ code: "en-US" }];
      return sourceLangs.map((item, index) => ({
        lang_code: item.code || item.lang_code || "en-US",
        content: index === 0 ? defaultContent : ""
      }));
    },
    hasLangContent(value) {
      if (!Array.isArray(value)) return !!value;
      return value.some(item => (item.content || "").trim() !== "");
    },
    listLang() {
      return this.listLanguage().then(response => {
        this.lang = response.data || [];
        this.objData.title = this.createMultilangValue("");
        this.objData.content = this.createMultilangValue("");
        this.objData.description = this.createMultilangValue("");
      });
    },
    addPagecontent(){
      this.submitted = true;
      this.errors = [];
      if (!this.hasLangContent(this.objData.title)) this.errors.push("Title không để trống");
      if (!this.hasLangContent(this.objData.content)) this.errors.push("Nội dung không để trống");
      if (!this.hasLangContent(this.objData.description)) this.errors.push("Mô tả ngắn không để trống");
      if (this.errors.length) {
        this.errors.forEach(err => this.$error(err));
        return;
      }
      this.loadings(true);
      this.savePageContent(this.objData).then(response => {
        this.loadings(false);
        this.$router.push({name:'pageContent'});
        this.$success('Thêm trang nội dung thành công');
      }).catch(error => {
        this.loadings(false);
        this.$error('Thêm trang nội dung thất bại');
      })
    }
  },
  mounted() {
    this.listLang();
  }
};
</script>