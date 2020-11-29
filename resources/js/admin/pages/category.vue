<template>
  <div>
    <div class="content">
      <div class="container-fluid">
        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
          <p class="_title0"> Category
            <Button @click="addModel=true">
              <Icon type="md-add"/>
              Add New Category
            </Button>
          </p>

          <div class="_overflow _table_div">
            <table class="_table">
              <!-- TABLE TITLE -->
              <tr>
                <th>ID</th>
                <th> Image</th>
                <th>Category Name</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
              <!-- TABLE TITLE -->


              <!-- ITEMS -->
              <tr v-for="(cat, i) in cats">
                <td>{{ cat.id }}</td>
                <td class="table_image">
                  <img :src="cat.iconImage"/>
                </td>
                <td class="_table_name">{{ cat.categoryName }}</td>
                <td>{{ cat.created_at }}</td>
                <td>
                  <Button type="info" size="small" @click="showEditModel(cat, i)">Edit</Button>
                  <Button type="error" size="small" @click="showDeletingModel(cat, i)" :loading="cat.isDeleting">Delete
                  </Button>

                </td>
              </tr>


            </table>
          </div>
        </div>
        <!--~~~~~~~  tag add model   ~~~~~~~~~-->
        <Modal
            v-model=addModel
            title=" Add New Category "
            :mask-closable="false"
            :closable="false"
        >
          <Input v-model="data.categoryName" placeholder="add Category name"/>
          <div class="space"></div>
          <Upload
              ref="uploads"
              type="drag"
              :headers="{'x-csrf-token' : token , 'x-Requested-with' : 'XMLHttpRequest'}"
              :on-success="handleSuccess"
              :on-error="handleError"
              :format="['jpg','jpeg','png']"
              :max-size="2048"
              :on-format-error="handleFormatError"
              action="/app/upload">
            <div style="padding: 20px 0">
              <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
              <p>Click or drag files here to upload</p>
            </div>
          </Upload>
          <div class="demo-upload-list" v-if="data.iconImage">
            <img :src="`/uploads/${data.iconImage}`"/>
            <div class="demo-upload-list-cover">
              <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
            </div>
          </div>
          <div slot="footer">
            <Button type="primary" @click="addCategory" :disable="isAdding" :loading="isAdding">
              {{ isAdding ? 'Adding' : 'Add New Tag' }}
            </Button>
            <Button type="default" @click="addModel=false">Close</Button>
          </div>
        </Modal>
        <!--~~~~~~~  tag edit model   ~~~~~~~~~-->
        <Modal
            v-model=editModel
            title=" Edit Category "
            :mask-closable="false"
            :closable="false"
        >
          <Input v-model="editData.categoryName" placeholder="Edit Category name"/>
          <div class="space"></div>
          <Upload v-show="isIconImageNew"
                  ref="editDataUploads"
                  type="drag"
                  :headers="{'x-csrf-token' : token , 'x-Requested-with' : 'XMLHttpRequest'}"
                  :on-success="handleSuccess"
                  :on-error="handleError"
                  :format="['jpg','jpeg','png']"
                  :max-size="2048"
                  :on-format-error="handleFormatError"
                  action="/app/upload">
            <div style="padding: 20px 0">
              <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
              <p>Click or drag files here to upload</p>
            </div>
          </Upload>
          <div class="demo-upload-list" v-if="editData.iconImage">
            <img :src="`${editData.iconImage}`"/>
            <div class="demo-upload-list-cover">
              <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
            </div>
          </div>
          <div slot="footer">
            <Button type="primary" @click="editCategory" :disable="isAdding" :loading="isAdding">
              {{ isAdding ? 'Editing' : 'Edit Category' }}
            </Button>
            <Button type="default" @click="closeEditingModel">Close</Button>
          </div>
        </Modal>
        <!--~~~~~~~  tag delete model   ~~~~~~~~~-->
        <Modal v-model="showDeleteModel" width="360">
          <p slot="header" style="color:#f60;text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span>Delete confirmation</span>
          </p>
          <div style="text-align:center">
            <p>Are you sure you want to delete tag?.</p>
          </div>
          <div slot="footer">
            <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting"
                    @click="deleteTag">
              Delete
            </Button>
          </div>
        </Modal>
      </div>
    </div>
  </div>
</template>
<script>
export default {

  data() {
    return {
      data: {
        categoryName: '',
        iconImage: '',
      },
      editData: {
        categoryName: '',
        iconImage: '',
      },
      addModel: false,
      editModel: false,
      showDeleteModel: false,
      isAdding: false,
      isDeleting: false,
      cats: [],
      index: -1,
      deleteItem: {},
      deletingIndex: -1,
      token: '',
      isIconImageNew: false,
      isEditingItemNew: false,
    }
  },
  methods: {
    async addCategory() {
      if (this.data.categoryName.trim() == '') return this.e('category name is required !')
      if (this.data.iconImage.trim() == '') return this.e('category image is required !')
      this.data.iconImage = `/uploads/${this.data.iconImage}`
      const res = await this.callApi('post', 'app/create_category', this.data)
      if (res.status === 201) {
        this.cats.unshift(res.data)
        this.s('category has been added successfully !')
        this.addModel = false
        this.data.categoryName = ''
        this.data.iconImage = ''
      } else {
        if (res.status === 422) {
          if (res.data.errors.categoryName) {
            this.i(res.data.errors.categoryName[0])
          }
          if (res.data.errors.iconImage) {
            this.i(res.data.errors.iconImage[0])
          }
        } else {
          this.swr()
        }

      }
    },
    async editCategory() {
      if (this.editData.categoryName.trim() == '') return this.e('category name is required !')
      if (this.editData.iconImage.trim() == '') return this.e('category image is required !')
      const res = await this.callApi('post', 'app/edit_category', this.editData)
      if (res.status === 200) {
        this.cats[this.index].categoryName = this.editData.categoryName
        this.s('Category has been updated successfully !')
        this.editModel = false
        this.tagName = ''
      } else {
        if (res.status === 422) {
         if (res.data.errors.categoryName) {
            this.i(res.data.errors.categoryName[0])
          }
          if (res.data.errors.iconImage) {
            this.i(res.data.errors.iconImage[0])
          }
        } else {
          this.swr()
        }

      }
    },
    showEditModel(cat, index) {
      /*  let obj = {
          id: tag.id,
          tagName: tag.tagName
        }*/
      this.editData = cat
      this.editModel = true
      this.index = index
      this.isEditingItemNew =true
    },
    async deleteTag() {
      this.isDeleting = true
      const res = await this.callApi('post', 'app/delete_tag', this.deleteItem)
      if (res.status === 200) {
        this.tags.splice(this.deletingIndex, 1)
        this.s('tag has been deleted successfully ')
      } else {
        this.swr()
      }
      this.isDeleting = false
      this.showDeleteModel = false
    },
    showDeletingModel(tag, i) {
      this.deleteItem = tag
      this.deletingIndex = i
      this.showDeleteModel = true
    },
    handleSuccess(res, file) {
      res = `/uploads/${res}`
      if (this.isEditingItemNew) {
        return this.editData.iconImage = res
      }
      this.data.iconImage = res
    },
    handleError(res, file) {
      this.$Notice.warning({
        title: "The file format is incorrect",
        desc: `${
            file.errors.file.length
                ? file.errors.file[0]
                : "Something went wrong!"
        }`
      });
    },
    handleFormatError(file) {
      this.$Notice.warning({
        title: 'The file format is incorrect',
        desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
      });
    },
    handleMaxSize(file) {
      this.$Notice.warning({
        title: 'Exceeding file size limit',
        desc: 'File  ' + file.name + ' is too large, no more than 2M.'
      });
    },
    async deleteImage(isAdd = true) {
      if (!isAdd) {
        let image
        this.isIconImageNew = true
         image = this.editData.iconImage
        this.editData.iconImage = ''
        this.$refs.editDataUploads.clearFiles()
      } else {
         image = this.data.iconImage
        this.data.iconImage = ''
        this.$refs.uploads.clearFiles()
      }
      const res = await this.callApi('post', 'app/delete_image', {imageName: image})
      if (res.status != 200) {
        this.data.iconImage = image;
        this.swr();
      }
    },
    closeEditingModel(){
      this.isEditingItemNew = true
      this.editModel = false
    }
  },
  async created() {
    this.token = window.Laravel.csrfToken
    const res = await this.callApi('get', 'app/get_category')
    if (res.status === 200) {
      this.cats = res.data
    } else {
      this.swr()
    }
  },
}
</script>