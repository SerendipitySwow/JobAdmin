import { mount } from '@vue/test-utils'
import maContainerFullBs from '@/components/ma-container/components/ma-container-full-bs.vue'

describe('ma-container-full-bs', () => {
  // 存在且是Vue组件实例
  it('is a vue instance', () => {
    const wrapper = mount(maContainerFullBs)

    expect(wrapper.exists()).toBeTruthy()
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  // 包含特定类名
  it('contains specific classnames', () => {
    const wrapper = mount(maContainerFullBs, {
      slots: {
        default: '<div>body</div>',
        header: '<div>header</div>',
        footer: '<div>footer</div>'
      }
    })

    expect(wrapper.is('.ma-container-full-bs')).toBeTruthy()
    expect(wrapper.contains('.ma-container-full-bs__header')).toBeTruthy()
    expect(wrapper.contains('.ma-container-full-bs__body')).toBeTruthy()
    expect(wrapper.contains('.ma-container-full-bs__body-wrapper-inner')).toBeTruthy()
    expect(wrapper.contains('.ma-container-full-bs__footer')).toBeTruthy()
  })

  // props
  it('has props', () => {
    const wrapper = mount(maContainerFullBs, {
      propsData: {
        betterScrollOptions: {}
      }
    })

    expect(wrapper.props().betterScrollOptions).toEqual({})
  })

  // 渲染slot
  it('has one or more slots', () => {
    const wrapper = mount(maContainerFullBs, {
      slots: {
        default: '<div>body</div>',
        header: '<div>header</div>',
        footer: '<div>footer</div>'
      }
    })

    expect(wrapper.text()).toMatch('header')
    expect(wrapper.text()).toMatch('body')
    expect(wrapper.text()).toMatch('footer')
  })
})
