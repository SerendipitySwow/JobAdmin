import { mount } from '@vue/test-utils'
import maSource from '@/components/ma-container/components/ma-source.vue'

describe('ma-source', () => {
  // 存在且是Vue组件实例
  it('is a vue instance', () => {
    const wrapper = mount(maSource, {
      stubs: ['ma-icon']
    })

    expect(wrapper.exists()).toBeTruthy()
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  // 包含特定类名
  it('contains specific classnames', (done) => {
    const wrapper = mount(maSource, {
      stubs: ['ma-icon']
    })

    expect(wrapper.is('.ma-source')).toBeTruthy()
    setTimeout(() => {
      expect(wrapper.contains('.ma-source--active')).toBeTruthy()
      done()
    }, 600)
  })

  // props
  it('has props', () => {
    const wrapper = mount(maSource, {
      stubs: ['ma-icon'],
      propsData: {
        filename: ''
      }
    })

    expect(wrapper.props().filename).toEqual('')
  })
})