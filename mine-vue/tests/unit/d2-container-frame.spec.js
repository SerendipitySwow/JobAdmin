import { mount } from '@vue/test-utils'
import maContainerFrame from '@/components/ma-container-frame/index.vue'

describe('ma-container-frame', () => {
  // 存在且是Vue组件实例
  it('is a vue instance', () => {
    const wrapper = mount(maContainerFrame, {
      stubs: ['ma-container']
    })

    expect(wrapper.exists()).toBeTruthy()
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  // 包含特定类名
  it('contains specific classnames', () => {
    const wrapper = mount(maContainerFrame, {
      stubs: ['ma-container']
    })

    expect(wrapper.contains('.ma-container-frame')).toBeTruthy()
  })

  // props
  it('has props', () => {
    const wrapper = mount(maContainerFrame, {
      stubs: ['ma-container'],
      propsData: {
        src: 'https://ma.pub/zh/doc/ma-admin'
      }
    })

    expect(wrapper.props().src).toEqual('https://ma.pub/zh/doc/ma-admin')
  })
})
