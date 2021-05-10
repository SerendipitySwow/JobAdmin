import { mount } from '@vue/test-utils'
import maContainerCardBs from '@/components/ma-container/components/ma-container-card-bs.vue'

describe('ma-container-card-bs', () => {
  // 存在且是Vue组件实例
  it('is a vue instance', () => {
    const wrapper = mount(maContainerCardBs)

    expect(wrapper.exists()).toBeTruthy()
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  // 包含特定类名
  it('contains specific classnames', () => {
    const wrapper = mount(maContainerCardBs, {
      slots: {
        default: '<div>body</div>',
        header: '<div>header</div>',
        footer: '<div>footer</div>'
      }
    })

    expect(wrapper.is('.ma-container-card-bs')).toBeTruthy()
    expect(wrapper.contains('.ma-container-card-bs__header')).toBeTruthy()
    expect(wrapper.contains('.ma-container-card-bs__body')).toBeTruthy()
    expect(wrapper.contains('.ma-container-card-bs__body-card')).toBeTruthy()
    expect(wrapper.contains('.ma-container-card-bs__footer')).toBeTruthy()
  })

  // props
  it('has props', () => {
    const wrapper = mount(maContainerCardBs, {
      propsData: {
        betterScrollOptions: {}
      }
    })

    expect(wrapper.props().betterScrollOptions).toEqual({})
  })

  // 渲染slot
  it('has one or more slots', () => {
    const wrapper = mount(maContainerCardBs, {
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
