<template>
    <div>
      <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <multi-lang-field
                  v-model="objData.name"
                  :languages="lang"
                  type="text"
                  label="Tên tour"
                  placeholder="Tên tour"
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
                <multi-lang-field
                  v-model="objData.description"
                  :languages="lang"
                  type="textarea"
                  label="Mô tả ngắn"
                  placeholder="Mô tả ngắn"
                />
              </div>
              <div class="form-group">
                <multi-lang-field
                  v-model="objData.highlights"
                  :languages="lang"
                  type="tinymce"
                  label="HIGHLIGHTS"
                />
              </div>
              <div class="form-group">
                <label>Ảnh tour</label>
                <ImageMulti v-model="objData.images" :title="'san-pham'"/> 
              </div>
              <div class="form-group">
                <label>Lộ Trình</label>
                <div v-for="(item, index) in objData.ingredient" :key="index">
                  <div class="row">
                    <div class="col-11">
                      <div class="row">
                        <div class="col-12">
                          <multi-lang-field
                            v-model="objData.ingredient[index].title"
                            :languages="lang"
                            type="text"
                            placeholder="Tiêu đề"
                          />
                          <br>
                          <multi-lang-field
                            v-model="objData.ingredient[index].content"
                            :languages="lang"
                            type="textarea"
                            placeholder="Nội dung"
                          />
                        </div>
                        <!-- <div class="col-3">
                          <image-upload
                          v-model="objData.ingredient[index].image"
                            type="avatar"
                            :title="'ingredient-sub-'"
                          ></image-upload>
                        </div> -->
                      </div>
                      <br />
                    </div>
                    <div class="col-1">
                      <a
                        href="javascript:;"
                        v-if="index != 0"
                        @click="remoteAr(index,'ingredient')"
                      >
                        <img v-bind:src="'/media/' + joke.avatar" width="25" />
                      </a>
                    </div>
                  </div>
                </div>

                <el-button size="small" @click="addInput('ingredient')"
                  >Thêm giá trị</el-button
                >
              </div>
              <div class="form-group tour-services-block">
                <label class="tour-services-title">Services</label>
                <h5 class="tour-services-subtitle">WHAT'S INCLUDED</h5>
                <div
                  v-for="(item, index) in objData.included_services"
                  :key="'included-' + index"
                  class="tour-service-row"
                >
                  <div class="row">
                    <div class="col-11">
                      <multi-lang-field
                        v-model="objData.included_services[index].content"
                        :languages="lang"
                        type="text"
                        :placeholder="'Mục included ' + (index + 1)"
                      />
                    </div>
                    <div class="col-1">
                      <a
                        href="javascript:;"
                        v-if="index != 0"
                        @click="remoteAr(index, 'included_services')"
                      >
                        <img v-bind:src="'/media/' + joke.avatar" width="25" />
                      </a>
                    </div>
                  </div>
                </div>
                <el-button size="small" @click="addInput('included_services')">
                  Thêm mục included
                </el-button>

                <h5 class="tour-services-subtitle m-t20">WHAT'S NOT INCLUDED</h5>
                <div
                  v-for="(item, index) in objData.excluded_services"
                  :key="'excluded-' + index"
                  class="tour-service-row"
                >
                  <div class="row">
                    <div class="col-11">
                      <multi-lang-field
                        v-model="objData.excluded_services[index].content"
                        :languages="lang"
                        type="text"
                        :placeholder="'Mục not included ' + (index + 1)"
                      />
                    </div>
                    <div class="col-1">
                      <a
                        href="javascript:;"
                        v-if="index != 0"
                        @click="remoteAr(index, 'excluded_services')"
                      >
                        <img v-bind:src="'/media/' + joke.avatar" width="25" />
                      </a>
                    </div>
                  </div>
                </div>
                <el-button size="small" @click="addInput('excluded_services')">
                  Thêm mục not included
                </el-button>
              </div>
              <div class="row">
                <div class="form-group col-4">
                <multi-lang-field
                  v-model="objData.price"
                  :languages="lang"
                  type="number"
                  label="Giá người lớn"
                  placeholder="0"
                />
              </div>
              <div class="form-group col-4">
                <multi-lang-field
                  v-model="objData.price_chil"
                  :languages="lang"
                  type="number"
                  label="Giá trẻ em"
                  placeholder="0"
                />
              </div>
              <div class="form-group col-4" v-if="variantstatus == false">
                <multi-lang-field
                  v-model="objData.discount"
                  :languages="lang"
                  type="number"
                  label="Giá chưa khuyến mãi"
                  placeholder="0"
                />
              </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label>Trạng thái</label>
                <vs-select v-model="objData.status">
                  <vs-select-item value="1" text="Còn hàng" />
                  <vs-select-item value="0" text="Hết hàng" />
                </vs-select>
              </div>
              <div class="form-group">
                <label>Danh mục tour</label>
                <vs-select
                  class="selectExample"
                  v-model="objData.category"
                  placeholder="Danh mục"
                  @change="findCategoryType()"
                >
                <vs-select-item
                    value="0"
                    text="Không danh mục"
                  />
                  <vs-select-item
                    :value="item.id"
                    :text="JSON.parse(item.name)[0].content"
                    v-for="(item, index) in cate"
                    :key="'f' + index"
                  />
                </vs-select>
              </div>
              <div class="form-group">
                <label>Danh mục cấp 1</label>
                <vs-select
                  class="selectExample"
                  v-model="objData.type_cate"
                  placeholder="Loại"
                  :disabled=" type_cate.length == 0"
                  @change="findCategoryTypeTwo()"
                >
                  <vs-select-item
                    :value="item.id"
                    :text="JSON.parse(item.name)[0].content"
                    v-for="(item, index) in type_cate"
                    :key="'v' + index"
                  />
                </vs-select>
              </div>
              <div class="form-group">
                <label>Thẻ tags cho sản phẩm</label>
                <vs-select
                    multiple
                    class="selectExample"
                    v-model="objData.tags"
                    @change="syncTagCateFromSelectedTags"
                    placeholder="--Chọn--"
                    >
                    <div :key="index" v-for="item,index in tags">
                      <vs-select-group :title="item.name" v-if="item.tags">
                        <vs-select-item :key="index" :value="i.slug" :text="i.name" v-for="i,index in item.tags"/>
                      </vs-select-group>
                    </div>
                </vs-select>
              </div>
              <div class="form-group">
                <label>Điểm Đến</label>
                <vs-input
                  type="text"
                  size="default"
                  placeholder="Thailand, Laos, Vietnam..."
                  class="w-100"
                  v-model="objData.origin"
                />
              </div>
              <div class="form-group">
                <label>Điểm Đi</label>
                <vs-input
                  type="text"
                  size="default"
                  placeholder="Thailand, Laos, Vietnam..."
                  class="w-100"
                  v-model="objData.thickness"
                />
              </div>
              <div class="form-group">
                <label>Số ngày <small class="text-muted">(dùng cho bộ lọc thời lượng)</small></label>
                <vs-input
                  type="number"
                  min="1"
                  size="default"
                  placeholder="VD: 15"
                  class="w-100"
                  v-model.number="objData.duration_days"
                />
              </div>
              <div class="form-group">
                <multi-lang-field
                  v-model="objData.hang_muc"
                  :languages="lang"
                  type="text"
                  label="Hành trình kéo dài"
                  placeholder="VD: 15 Days / 15 Ngày"
                />
              </div>
              <div class="form-group">
                <label>Tour nổi bật</label>
                <vs-select v-model="objData.discountStatus">
                  <vs-select-item value="1" text="Có" />
                  <vs-select-item value="0" text="Không" />
                </vs-select>
              </div>
              <div class="form-group">
                <label>Hiển thị trang chủ</label>
                <vs-select v-model="objData.home_status">
                  <vs-select-item value="1" text="Có" />
                  <vs-select-item value="0" text="Không" />
                </vs-select>
              </div>
            </div>
          </div> 
        </div>
      </div>
      <div class="row fixxed">
        <div class="col-12">
          <div class="saveButton">
            <vs-button color="primary" @click="saveProducts"
              >Thêm mới</vs-button
            >
          </div>
        </div>
      </div>
    </div>
</template>


<script>
import { mapActions } from "vuex";
import TinyMce from "../_common/tinymce";
import ImageMulti from "../_common/upload_image_multi";
import "tinymce/icons/default/icons.min.js";
import InputTag from "vue-input-tag";
import InputColorPicker from "vue-native-color-picker";
export default {
  name: "product",
  data() {
    return {
      cate: [],
      joke: {
        avatar: "delete-sign--v2.png",
      },
      type_cate: [],
      tags: [],
      checkBox1:{
        roleid:[]
      },
      linhtinh:[],
      
      type_two:[],
      cate_build_pc:[
        {
          name: 'Vi xử lý',
          value:'cpu'
        },
        {
          name: 'Bo mạch chủ',
          value:'mainboard'
        },
        {
          name: 'Ram',
          value:'ram'
        },
        {
          name: 'Ổ Cứng',
          value:'o-cung'
        },
        {
          name: 'VGA',
          value:'vga'
        },
        {
          name: 'Nguồn',
          value:'nguon'
        },
        {
          name: 'Vỏ Case',
          value:'case'
        },
        {
          name: 'Tản nhiệt',
          value:'tan-nhiet'
        },
        {
          name: 'Màn hình',
          value:'man-hinh'
        },
        {
          name: 'Bàn phím',
          value:'ban-phim'
        },
        {
          name: 'Chuột',
          value:'chuot'
        },
        {
          name: 'Tai nghe',
          value:'tai-nghe'
        },
        {
          name: 'Loa máy tính',
          value:'loa-may-tinh'
        }
      ],
      variant_value:[],
      variant:[],
      VariantSku:[],
      variant_item:{},
      variantstatus:false,
      lang: [],
      errors: [],
      cateservice:[],
      lungtung2:[],
      objData: {
        lang: "",
        cate_build_pc:"",
        variant:[],
        name: [
          {
            lang_code: "en-US",
            content: "",
          },
        ],
        size: [
          {
            title: "",
            detail: ""
          },
        ],
        tags:[],
        tag_cate: 0,
        price: [
          {
            lang_code: "en-US",
            content: 0,
          },
        ],
        price_chil:[
          {
            lang_code: "en-US",
            content: 0,
          },
        ],
        discount: [
          {
            lang_code: "en-US",
            content: 0,
          },
        ],
        preserve:[
        {
            date_name: "",
            detail_date: [
              {
                name: ""
              }
            ]
          },
        ],
        ingredient:[
          {
            title: [
              {
                lang_code: "en-US",
                content: "",
              },
              {
                lang_code: "es-ES",
                content: "",
              },
            ],
            image: "",
            content:[
              {
                lang_code: "en-US",
                content: "",
              },
              {
                lang_code: "es-ES",
                content: "",
              },
            ]
          },
        ],
        included_services: [
          {
            content: [
              { lang_code: "en-US", content: "" },
              { lang_code: "es-ES", content: "" },
            ],
          },
        ],
        excluded_services: [
          {
            content: [
              { lang_code: "en-US", content: "" },
              { lang_code: "es-ES", content: "" },
            ],
          },
        ],
        images: [],
        qty: "",
        description: [
          {
            lang_code: "en-US",
            content: "",
          },
        ],
        highlights: [
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
        category: 0,
        status: 1,
        discountStatus:0,
        type_cate: 0,
        type_two:0,
        origin: "",
        thickness: "",
        hang_muc: [
          {
            lang_code: "en-US",
            content: "",
          },
        ],
        duration_days: "",
        service_id:0,
        lungtung:[],
        status_variant: 0,
        home_status:0
      },
    };
  },
  components: {
    TinyMce,
    ImageMulti,
    InputTag,
    "v-input-colorpicker": InputColorPicker
  },
  computed: {},
  watch: {
  },
  methods: {
    ...mapActions([
      "editId",
      "saveProduct",
      "listCate",
      "loadings",
      "listLanguage",
      "findTypeCate",
      "findTypeCateTwo",
      "listCateService",
      "listVariant",
      "listVariantValue",
      "findTags",
      ,"listVariantSku"
    ]),
    listVariantSkuValue(){
      this.listVariantSku({id:this.$route.params.id}).then(response => {
        this.VariantSku = response.data;
        this.lungtung2 = response.data;
      }).catch(error => {
        console.log(12);
      });
    },
    choiseVariant(event){
      this.objData.status_variant = 1;
      this.listVariantValue({id:event.id}).then(response => {
        if (this.variant_value.length == 0) {
          var obj = {};
          obj.name = event.name;
          obj.value = response.data;
          this.variant_value.push(obj);
        }else if(!this.variant_value.some(data => data.name === event.name)){
          var obj = {};
          obj.name = event.name;
          obj.value = response.data;
          this.variant_value.push(obj);
        }
      }).catch(error => {

      })
    },
    getValuebuildSkua(variant_value, variant){
      if(this.linhtinh.length == 0){
        this.linhtinh.push(this.getValuebuildSku(variant_value, variant));
      }else{
        this.linhtinh.forEach((element, key) => { 
          if(this.linhtinh.some(data => data.display_name === variant)){
            console.log(1);
            // console.log(variant_value, element.display_name)
            if(!element.option_values.some(data => data.label === variant_value) && this.linhtinh[key].display_name == variant){
              var obj = {};
              obj.label = variant_value;
              obj._id = 13
              this.linhtinh[key].option_values.push(obj);
            }else if(element.option_values.some(data => data.label === variant_value)){
              const idxObj = this.linhtinh[key].option_values.findIndex(obj => {
                return obj.label === variant_value;
              });
              this.linhtinh[key].option_values.splice(idxObj, 1);
            }
          }else{
            this.linhtinh.push(this.getValuebuildSku(variant_value, variant));
          }
        });
      }
      this.objData.variant = this.linhtinh;
      let sets = [[]];
      const id_obj = {};
      this.linhtinh.forEach(option => {
        const new_sets = [];
        option.option_values.forEach(({ label, _id }) => {
          new_sets.push(Array.from(sets, set => [...set, label]));
          id_obj[label] = { id: option._id, value_id: _id };
        });
        sets = new_sets.flatMap(set => set);
      });

      this.lungtung2 =  sets.map(set => ({
        price: 0,
        qty:0, 
        version: set.join("-"),
        sku: "",
        option_values: set.map(label => ({ option_id: id_obj[label].value_id, id: id_obj[label].id }))
      }));

    },
    getValuebuildSku(variant_value, variant){
      var arr = [];
      var objOtion = {
        option_values:[]
      };
      objOtion.display_name = variant;
        var obj = {};
        obj._id = 12;
        obj.label = variant_value;
        objOtion.option_values.push(obj);
        
      return objOtion;
    },
    syncTagCateFromSelectedTags() {
      const selectedTags = Array.isArray(this.objData.tags) ? this.objData.tags : [];
      if (selectedTags.length === 0) {
        this.objData.tag_cate = 0;
        return;
      }

      const matchedTagCate = this.tags.find((tagCate) => {
        return Array.isArray(tagCate.tags) && tagCate.tags.some((tag) => selectedTags.includes(tag.slug));
      });

      this.objData.tag_cate = matchedTagCate ? Number(matchedTagCate.id) : 0;
    },
    syncDurationDays() {
      if (this.objData.duration_days) {
        return;
      }
      const items = Array.isArray(this.objData.hang_muc) ? this.objData.hang_muc : [];
      for (const item of items) {
        const text = (item && item.content) ? String(item.content) : "";
        const match = text.match(/(\d+)/);
        if (match) {
          this.objData.duration_days = parseInt(match[1], 10);
          return;
        }
      }
    },
    saveProducts() {
      this.errors = [];
      this.syncTagCateFromSelectedTags();
      this.syncDurationDays();
     if(this.objData.name[0].content == '') this.errors.push('Tên không được để trống');
      if(this.objData.content[0].content == '') this.errors.push('Nội dung không được để trống');
      if(this.objData.description[0].content == '') this.errors.push('Mô tả không được để trống');
      if(this.objData.images.length == 0) this.errors.push('Vui lòng chọn ảnh');
      if(this.objData.category == 0) this.errors.push('Chọn danh mục sản phẩm');
      if(this.objData.price == 0) this.errors.push('Nhập giá người lớn');
      if (this.errors.length > 0) {
        this.errors.forEach((value, key) => {
          this.$error(value);
        });
        return;
      } else {
        this.loadings(true);
        this.objData.lungtung = this.lungtung2;
        this.saveProduct(this.objData)
          .then((response) => {
            this.loadings(false);
            this.$router.push({ name: "listProduct" });
            this.$success("Thêm sản phẩm thành công");
            this.$route.push({ name: "listProduct" });
          })
          .catch((error) => {
            this.loadings(false);
            // this.$vs.notify({
            //   title: "Thất bại",
            //   text: "Thất bại",
            //   color: "danger",
            //   position: "top-right"
            // });
          });
      }
    },
    
    findCategoryType() {
      this.findTypeCate(this.objData.category).then((response) => {
        this.type_cate = response.data;
      });
    },
    listVariants(){
      this.listVariant().then(response => {
        this.variant = response.data
      }).catch(error => {

      })
    },
    findCategoryTypeTwo() {
      this.findTypeCateTwo(this.objData.type_cate).then((response) => {
        this.type_two = response.data;
      });
    },
    addDetailTask(key,index){
      var oj = {};
      if(key =='preserve'){
        oj.name = "";
        this.objData.preserve[index].detail_date.push(oj);
      }
    },
    remoteDetailTaskr(index,keytaskdetail) {
        this.objData.preserve[index].detail_date.splice(keytaskdetail, 1);
    },
    createServiceItem() {
      const langs =
        this.lang && this.lang.length
          ? this.lang.map((l) => ({ lang_code: l.code, content: "" }))
          : [
              { lang_code: "en-US", content: "" },
              { lang_code: "es-ES", content: "" },
            ];
      return { content: langs };
    },
    parseServiceList(value) {
      if (!value) {
        return [this.createServiceItem()];
      }
      let parsed = value;
      if (typeof value === "string") {
        try {
          parsed = JSON.parse(value);
        } catch (e) {
          return [this.createServiceItem()];
        }
      }
      if (!Array.isArray(parsed) || parsed.length === 0) {
        return [this.createServiceItem()];
      }
      return parsed.map((item) => ({
        content: this.normalizeMultilang(item.content || item),
      }));
    },
    remoteAr(index,key) {
      if(key == 'size'){
        this.objData.size.splice(index, 1);
      }
      if(key == 'ingredient'){
        this.objData.ingredient.splice(index, 1);
      }
      if(key == 'preserve'){
        this.objData.preserve.splice(index, 1);
      }
        if(key == 'species'){
        this.objData.species.splice(index, 1);
      }
      if (key === "included_services") {
        this.objData.included_services.splice(index, 1);
      }
      if (key === "excluded_services") {
        this.objData.excluded_services.splice(index, 1);
      }
    },
    addInput(key) {
        var oj = {};
        if(key =='preserve'){
          oj.date_name = "";
          oj.detail_date = [
              {
                name: ""
              }
            ];
          this.objData.preserve.push(oj);
        }
        if(key =='ingredient'){
          oj.title =  [
              {
                lang_code: "en-US",
                content: "",
              },
              {
                lang_code: "es-ES",
                content: "",
              },
            ];
          oj.image = "";
          oj.content =  [
              {
                lang_code: "en-US",
                content: "",
              },
              {
                lang_code: "es-ES",
                content: "",
              },
            ];
          this.objData.ingredient.push(oj);
        }
        if(key =='species'){
          oj.detail = "";
          this.objData.species.push(oj);
        }
        if(key =='size'){
          oj.title = "";
          oj.detail = "";
          this.objData.size.push(oj);
        }
        if (key === "included_services") {
          this.objData.included_services.push(this.createServiceItem());
        }
        if (key === "excluded_services") {
          this.objData.excluded_services.push(this.createServiceItem());
        }
    },
    normalizeMultilang(value, defaultValue = "") {
      if (typeof value === "string") {
        try {
          const parsed = JSON.parse(value);
          if (Array.isArray(parsed)) {
            return this.normalizeMultilang(parsed, defaultValue);
          }
        } catch (e) {}
      }

      if (Array.isArray(value)) {
        return value.map((item, index) => ({
          lang_code: item.lang_code || (index === 0 ? "en-US" : "es-ES"),
          content: item.content === undefined ? defaultValue : item.content,
        }));
      }

      return [
        {
          lang_code: "en-US",
          content: value || defaultValue,
        },
        {
          lang_code: "es-ES",
          content: defaultValue,
        },
      ];
    },
    normalizeIngredient(item = {}) {
      return {
        ...item,
        title: this.normalizeMultilang(item.title, ""),
        content: this.normalizeMultilang(item.content, ""),
        image: item.image || "",
      };
    },
    listLang() {
      this.listLanguage()
        .then((response) => {
          this.loadings(false);
          this.lang = response.data;
        })
        .catch((error) => {});
    },
    editById() {
      this.loadings(true);
      this.editId({id:this.$route.params.id}).then(response => {
        this.loadings(false);
          this.objData = response.data;
          this.objData.name = this.normalizeMultilang(response.data.name);
          this.objData.images = JSON.parse(response.data.images);
          this.objData.content = JSON.parse(response.data.content);
          this.objData.price = JSON.parse(response.data.price);
          this.objData.price_chil = JSON.parse(response.data.price_chil);
          this.objData.discount = JSON.parse(response.data.discount);
          this.objData.description = JSON.parse(response.data.description);
          this.objData.highlights = response.data.highlights
            ? JSON.parse(response.data.highlights)
            : [{ lang_code: "en-US", content: "" }];
          this.objData.tags = JSON.parse(response.data.tags);
          this.objData.variant = JSON.parse(response.data.variant);
          if(response.data.ingredient == null){
            this.objData.ingredient = [this.normalizeIngredient()]
          }else{
            this.objData.ingredient = JSON.parse(response.data.ingredient).map((item) => this.normalizeIngredient(item));
          }
          if(response.data.size == ""){
            this.objData.size = [{title: "",detail: ""}]
          }else{
            this.objData.size = JSON.parse(response.data.size);
          }
          if(response.data.preserve == null){
            this.objData.preserve = [{
            date_name: "",
            detail_date: [
              {
                name: ""
              }
            ]
          }]
          }else{
            this.objData.preserve = JSON.parse(response.data.preserve);
          }
          this.objData.hang_muc = this.normalizeMultilang(response.data.hang_muc);
          this.objData.duration_days = response.data.duration_days || "";
          this.objData.included_services = this.parseServiceList(
            response.data.included_services
          );
          this.objData.excluded_services = this.parseServiceList(
            response.data.excluded_services
          );
      }).catch(error => {
        console.log(12);
      });
    },
  },
  mounted() {
    this.loadings(true);
    this.editById();
    this.listCate().then((response) => {
      this.loadings(false);
      this.cate = response.data;
    });
    this.findTags().then((response) => {
        this.tags = response.data;
      });
     this.listCateService().then((response) => {
      this.loadings(false);
      this.cateservice = response.data;
    });
    this.listVariants();
    this.listLang();
    this.listVariantSkuValue();
  },
};
</script>
<style scoped>
.tour-services-title {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 12px;
  display: block;
}
.tour-services-subtitle {
  font-size: 15px;
  font-weight: 600;
  margin: 16px 0 10px;
}
.tour-service-row {
  margin-bottom: 12px;
}
.m-t20 {
  margin-top: 20px;
}
.centerx li {
    list-style: none!important;
}
.centerx, .con-notifications, .con-notifications-position {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
}
.selectExample {
  margin: 10px;
}
.con-select-example {
  display: flex;
  align-items: center;
  justify-content: center;
}
.con-select .vs-select {
  width: 100%
}
@media (max-width: 550px) {
  .con-select {
    flex-direction: column;
  }
  .con-select .vs-select {
    width: 100%
  }
}
</style>