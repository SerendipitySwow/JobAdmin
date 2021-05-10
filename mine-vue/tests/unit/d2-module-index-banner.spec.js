import { mount } from '@vue/test-utils'
import maModuleIndexBanner from '@/components/ma-module-index-banner/index.vue'

describe('ma-module-index-banner', () => {
  // 存在且是Vue组件实例
  it('is a vue instance', () => {
    const wrapper = mount(maModuleIndexBanner, {
      stubs: ['ma-icon']
    })

    expect(wrapper.exists()).toBeTruthy()
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  // props
  it('has props', () => {
    const wrapper = mount(maModuleIndexBanner, {
      stubs: ['ma-icon'],
      propsData: {
        title: 'title',
        subTitle: 'subTitle',
        link: 'link'
      }
    })

    expect(wrapper.props().title).toEqual('title')
    expect(wrapper.props().subTitle).toEqual('subTitle')
    expect(wrapper.props().link).toEqual('link')
  })
})
