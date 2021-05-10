import { mount } from '@vue/test-utils'
import maIconSvg from '@/components/ma-icon-svg/index.vue'

describe('ma-icon-svg', () => {
  // 存在且是Vue组件实例
  it('is a vue instance', () => {
    const wrapper = mount(maIconSvg, {
      propsData: {
        name: 'add'
      }
    })

    expect(wrapper.exists()).toBeTruthy()
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  // props
  it('has props', () => {
    const wrapper = mount(maIconSvg, {
      propsData: {
        name: 'add'
      }
    })

    expect(wrapper.props().name).toEqual('add')
  })
})
