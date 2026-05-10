<template>
  <!-- partial -->
  <div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title" @click="listCate">Danh sách danh mục</h4>
              <p class="card-description">Thêm mới hoặc sửa chửa danh mục sản phẩm</p>
              <router-link class="nav-link" :to="{name:'add_category'}">
                <vs-button type="gradient" style="float:right;">Thêm mới</vs-button>
              </router-link>
              <vs-button color="primary" type="filled" style="float:right; margin-right:10px;" @click="saveSortOrder">
                Lưu thứ tự
              </vs-button>
              <vs-input
                icon="search"
                placeholder="Search"
                v-model="keyword"
                @keyup="searchCategory()"
              />
              <vs-table stripe :data="list">
                <template slot="thead">
                  <vs-th>ID</vs-th>
                  <vs-th>Thứ tự</vs-th>
                  <vs-th>Tên</vs-th>
                  <vs-th>Ảnh bìa</vs-th>
                  <vs-th>Title</vs-th>
                  <vs-th>Hành động</vs-th>
                </template>
                <template slot-scope="{data}">
                  <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                    <vs-td :data="tr.id">{{tr.id}}</vs-td>
                    <vs-td :data="tr.sort_order">
                      <div class="sort-control">
                        <vs-button
                          size="small"
                          color="primary"
                          icon="keyboard_arrow_up"
                          :disabled="indextr === 0"
                          @click="moveCategory(indextr, -1)"
                        ></vs-button>
                        <vs-button
                          size="small"
                          color="primary"
                          icon="keyboard_arrow_down"
                          :disabled="indextr === list.length - 1"
                          @click="moveCategory(indextr, 1)"
                        ></vs-button>
                        <input
                          type="number"
                          class="sort-input"
                          v-model.number="tr.sort_order"
                          @change="normalizeSortOrder"
                        >
                      </div>
                    </vs-td>
                    <vs-td :data="tr.name">{{JSON.parse(tr.name)[0].content}}</vs-td>
                    <vs-td :data="tr.id">
                      <vs-avatar size="70px" :src="tr.avatar" />
                    </vs-td>
                    <vs-td :data="tr.id">{{tr.path}}</vs-td>
                    <vs-td :data="tr.id">
                      <router-link :to="{name:'edit_category',params:{id:tr.id}}">
                        <vs-button
                          vs-type="gradient"
                          size="lagre"
                          color="success" 
                          icon="edit"
                        ></vs-button>
                      </router-link>
                      <vs-button vs-type="gradient" size="lagre" color="red" icon="delete_forever" @click="confirmDestroy(tr.id)"></vs-button>
                    </vs-td>
                  </vs-tr>
                </template>
              </vs-table>
            </div>
          </div>
        </div>
      </div>
      <vs-popup style="width:100%;" title="Thêm mới danh mục" :active.sync="popupActivo">
        <ModalAdd @closePopup="closePop($event)" />
      </vs-popup>
  </div>
</template>


<script>
import ModalAdd from "../../components/layouts/modal/category/add";

import { mapActions } from "vuex";
export default {
  data: () => ({
    keyword: null,
    popupActivo: false,
    list: [],
    timer:0,
    id_item :''
  }),
  components: {
    ModalAdd
  },
  computed: {
    
  },
  methods: {
    ...mapActions(["listCate","destroyCate", "sortCate", "loadings"]),
    closePop(event) {
      this.listCategory();
      this.popupActivo = event;
    },
    listCategory() {
      this.loadings(true);
      this.listCate({ keyword: this.keyword })
      .then(response => {
          this.loadings(false);
          this.list = this.prepareSortOrder(response.data);
        });
    },
    searchCategory() {
      if (this.timer) {
        clearTimeout(this.timer);
        this.timer = null;
      }
      this.timer = setTimeout(() => {
          this.listCate({ keyword: this.keyword })
          .then(response => {
            this.list = this.prepareSortOrder(response.data);
          });
      }, 800);
    },
    prepareSortOrder(data) {
      return (data || []).map((item, index) => ({
        ...item,
        sort_order: item.sort_order && parseInt(item.sort_order) > 0 ? parseInt(item.sort_order) : index + 1
      }));
    },
    normalizeSortOrder() {
      this.list = this.list
        .map((item, index) => ({
          ...item,
          sort_order: item.sort_order && parseInt(item.sort_order) > 0 ? parseInt(item.sort_order) : index + 1
        }))
        .sort((a, b) => parseInt(a.sort_order) - parseInt(b.sort_order));
    },
    moveCategory(index, direction) {
      const target = index + direction;
      if (target < 0 || target >= this.list.length) return;
      const next = [...this.list];
      const currentItem = next[index];
      next.splice(index, 1);
      next.splice(target, 0, currentItem);
      this.list = next.map((item, idx) => ({
        ...item,
        sort_order: idx + 1
      }));
    },
    saveSortOrder() {
      this.loadings(true);
      this.sortCate({
        categories: this.list.map((item, index) => ({
          id: item.id,
          sort_order: index + 1
        }))
      }).then(() => {
        this.loadings(false);
        this.$success('Lưu thứ tự danh mục thành công');
        this.listCategory();
      }).catch(() => {
        this.loadings(false);
        this.$error('Lưu thứ tự danh mục thất bại');
      });
    },
    destroy(){
      this.loadings(true);
      this.destroyCate({id:this.id_item})
      .then(response => {
        this.listCategory()
        this.loadings(false);
        this.$success('Xóa danh mục thành công');
      });
    },
    confirmDestroy(id){
      this.id_item = id;
      this.$vs.dialog({
        type:'confirm',
        color: 'danger',
        title: `Bạn có chắc chắn`,
        text: 'Xóa danh mục này',
        accept:this.destroy
      })
    }
  },
  mounted() {
    this.listCategory()
  }
};
</script>
<style>
.sort-control {
  display: flex;
  align-items: center;
  gap: 6px;
}

.sort-input {
  width: 64px;
  height: 34px;
  border: 1px solid #d8d8d8;
  border-radius: 6px;
  padding: 0 8px;
  text-align: center;
}
</style>