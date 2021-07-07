import PreviewComponent from './components/preview'

export default {
  install(Vue, options) {
    const PreviewConstructor = Vue.extend(PreviewComponent)
    const preview = new PreviewConstructor()

    preview.$mount(preview.$el)
    Vue.prototype.$preview = (image, index = 0) => {
      preview.visible(image, index)
    }
  }
}
