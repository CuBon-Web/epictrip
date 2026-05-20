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
                <div class="form-group">
                  <label>Ảnh đại diện</label>
                  <image-upload
                    v-model="objData.image"
                    type="avatar"
                    :title="'danh-muc-dich-vu'"
                  ></image-upload>
                </div>
                <div class="form-group">
                  <multi-lang-field
                    v-model="objData.description"
                    :languages="lang"
                    type="textarea"
                    label="Mô tả ngắn"
                  />
                </div>
                <div class="form-group">
                  <multi-lang-field
                    v-model="objData.content"
                    :languages="lang"
                    type="tinymce"
                    label="Nội dung"
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
      showLang: {
        name: false,
        content: false,
      },
      objData: {
        id:this.$route.params.id,
        name: [
          {
            lang_code: "en-US",
            content: "",
          },
        ],
        content: [
          {
            lang_code: "en-US",
            content: "",
          },
        ],
        image: "",
        status: "",
        description: [
          {
            lang_code: "en-US",
            content: "",
          },
        ]
      },
      lang:[],
      img: "",
      errors:[]
    };
  },
  methods: {
    ...mapActions(["getInfoCateService","saveCategoryService","listLanguage", "loadings"]),
    nameImage(event) {
      this.objData.avatar = event;
    },
    showSettingLangExist(value) {
      if (value == "name") {
        this.showLang.name = !this.showLang.name;
        this.lang.forEach((value, index) => {
          if (
            !this.objData.name[index] &&
            value.code != this.objData.name[0].lang_code
          ) {
            var oj = {};
            oj.lang_code = value.code;
            oj.content = "";
            this.objData.name.push(oj);
          }
        });
      }
      if (value == "content") {
        this.showLang.content = !this.showLang.content;
        this.lang.forEach((value, index) => {
          if (
            !this.objData.content[index] &&
            value.code != this.objData.content[0].lang_code
          ) {
            var oj = {};
            oj.lang_code = value.code;
            oj.content = "";
            this.objData.content.push(oj);
          }
        });
      }
    },
    parseMultilangField(value) {
      if (!value) {
        return [{ lang_code: "en-US", content: "" }];
      }
      if (Array.isArray(value)) {
        return value;
      }
      try {
        const parsed = JSON.parse(value);
        if (Array.isArray(parsed)) {
          return parsed;
        }
      } catch (e) {}
      return [{ lang_code: "en-US", content: value }];
    },
    saveEdit() {
      this.errors = [];
      if(this.objData.name[0].content == '') this.errors.push('Tên danh mục không được để trống');
      if(!this.objData.description[0].content || !String(this.objData.description[0].content).trim()) {
        this.errors.push('Mô tả ngắn không được để trống');
      }
      if (this.errors.length > 0) {
        this.errors.forEach((value, key) => {
          this.$error(value)
        })
        return;
      } else {
        this.loadings(true);
        this.saveCategoryService(this.objData)
        .then(response => {
            this.loadings(false);
            this.$router.push({ name: "list_category_service" });
            this.$success("Sửa danh mục thành công");
            this.$route.push({ name: "list_category_service" });
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
      this.getInfoCateService(this.objData).then(response => {
        this.loadings(false);
        if(response.data == null){
          this.objData ={
            id:this.$route.params.id,
            name: "",
            content: "",
            image: "",
            status: "",
          }
        }else{
          this.objData = response.data;
          this.objData.content = JSON.parse(response.data.content);
          this.objData.name = JSON.parse(response.data.name);
          this.objData.description = this.parseMultilangField(response.data.description);
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