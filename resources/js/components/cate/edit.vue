<template>
  <div>
      <div class="row">
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-3"><h4 class="card-title">Sửa danh mục sản phẩm</h4></div>
                <div class="col-md-6"></div>
                <div class="col-md-3">
                  </div>
              </div>
              
              
              <!-- <p class="card-description">Basic form elements</p> -->
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
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                  <label>Ảnh bản đồ</label>
                  <image-upload
                    v-model="objData.avatar"
                    type="avatar"
                    :title="'danh-muc'"
                  ></image-upload>
                </div>
                <div class="form-group">
                  <label>Ảnh đại diện</label>
                  <image-upload
                    v-model="objData.imagehome"
                    type="avatar"
                    :title="'trang-chu'"
                  ></image-upload>
                </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                  <multi-lang-field
                    v-model="objData.content_table"
                    :languages="lang"
                    type="tinymce"
                    label=" Bảng thông tin chung"
                  />
                </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <multi-lang-field
                    v-model="objData.content"
                    :languages="lang"
                    type="tinymce"
                    label="Giới thiệu"
                  />
                </div>
                <div class="form-group">
                  <label for="exampleInputName1">Trạng thái</label>
                  <vs-select v-model="objData.status"
                  >
                      <vs-select-item  value="1" text="Hiện" />
                      <vs-select-item  value="0" text="Ẩn" />
                    </vs-select>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="row fixxed">
        <div class="col-12">
          <div class="saveButton">
            <vs-button color="primary" @click="saveEdit()">Cập nhật</vs-button>
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
      showLang:{
        title:false
      },
      objData: {
        id:this.$route.params.id,
        name: [
          {
            lang_code:'en-US',
            content:''
          }
        ],
        content: [
          {
            lang_code:'en-US',
            content:''
          }
        ],  
        content_table: [
          {
            lang_code:'en-US',
            content:''
          }
        ],
        avatar: "",
        imagehome: "",
        status: "",
      },
      lang:[],
      img: "",
      errors:[]
    };
  },
  components: {},
  methods: {
    ...mapActions(["getInfoCate","saveCategory","listLanguage", "loadings"]),
    nameImage(event) {
      this.objData.avatar = event;
    },
    showSettingLangExist(value){
        this.showLang.title = !this.showLang.title
          this.lang.forEach((value, index) => {
              if(!this.objData.name[index] && value.code != this.objData.name[0].lang_code){
                  var oj = {};
                  oj.lang_code = value.code;
                  oj.content = ''
                  this.objData.name.push(oj)
              }
          });
    },
    parseMultilang(value) {
      if (Array.isArray(value)) return value;
      if (typeof value === "string" && value !== "") {
        try {
          const parsed = JSON.parse(value);
          if (Array.isArray(parsed)) return parsed;
        } catch (e) {
          return [{ lang_code: "en-US", content: value }];
        }
      }
      return [{ lang_code: "en-US", content: "" }];
    },
    saveEdit() {
      this.errors = [];
      if(this.objData.name[0].content == '') this.errors.push('Tên danh mục không được để trống');
      if (this.errors.length > 0) {
        this.errors.forEach((value, key) => {
          this.$error(value)
        })
        return;
      } else {
        this.loadings(true);
        this.saveCategory(this.objData)
        .then(response => {
            this.loadings(false);
            this.$router.push({ name: "list_category" });
            this.$success("Sửa danh mục thành công");
            this.$route.push({ name: "list_category" });
          })
          .catch(error => {
            this.loadings(false);
            // this.$error('Sửa danh mục thất bại');
          });
      }
    },
    listLang(){
      this.listLanguage().then(response => {
        this.loadings(false);
        this.lang  = response.data
      }).catch(error => {

      })
    },
    getInfoCates(){
      this.loadings(true);
      this.getInfoCate(this.objData).then(response => {
        this.loadings(false);
        if(response.data == null){
          this.objData ={
            id:this.$route.params.id,
            name: [{ lang_code: "en-US", content: "" }],
            content: [{ lang_code: "en-US", content: "" }],
            content_table: [{ lang_code: "en-US", content: "" }],
            path: "",
            avatar: "",
            status: "",
          }
        }else{
          this.objData = response.data;
          this.objData.name = this.parseMultilang(response.data.name);
          this.objData.content = this.parseMultilang(response.data.content);
          this.objData.content_table = this.parseMultilang(response.data.content_table);
        }
      }).catch(error => {
        console.log(12);
      });
    },
    changeLanguage(data){
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