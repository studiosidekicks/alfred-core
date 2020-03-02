<template>
  <div class="upload-container">
    <el-upload
      :data="additionalData"
      :multiple="false"
      :show-file-list="false"
      :on-success="handleImageSuccess"
      class="image-uploader"
      drag
      action="https://httpbin.org/post"
    >
      <i class="el-icon-upload" />
      <div class="el-upload__text">
        Drag files here or <em>Click to upload</em>
      </div>
    </el-upload>
    <div class="image-preview image-app-preview">
      <div v-show="imageUrl.length>1" class="image-preview-wrapper">
        <img :src="imageUrl">
        <div class="image-preview-action">
          <i class="el-icon-delete" @click="rmImage" />
        </div>
      </div>
    </div>
    <div class="image-preview">
      <div v-show="imageUrl.length>1" class="image-preview-wrapper">
        <img :src="imageUrl">
        <div class="image-preview-action">
          <i class="el-icon-delete" @click="rmImage" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SingleImageUpload3',
  props: {
    value: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      tempUrl: '',
      additionalData: {},
    };
  },
  computed: {
    imageUrl() {
      return this.value;
    },
  },
  methods: {
    rmImage() {
      this.emitInput('');
    },
    emitInput(val) {
      this.$emit('input', val);
    },
    handleImageSuccess(file) {
      this.emitInput(file.files.file);
    },
  },
};
</script>