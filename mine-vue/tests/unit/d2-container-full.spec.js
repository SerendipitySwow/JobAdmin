import { mount } from '@vue/test-utils'
import maContainerFull from '@/components/ma-container/components/ma-container-full.vue'

describe('ma-container-full', () => {
  // 存在且是Vue组件实例
  it('is a vue instance', () => {
    const wrapper = mount(maContainerFull)

    expect(wrapper.exists()).toBeTruthy()
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  // 包含特定类名
  it('contains specific classnames', () => {
    const wrapper = mount(maContainerFull, {
      slots: {
        default: '<div>body</div>',
        header: '<div>header</div>',
        footer: '<div>footer</div>'
      }
    })

    expect(wrapper.is('.ma-container-full')).toBeTruthy()
    expect(wrapper.contains('.ma-container-full__header')).toBeTruthy()
    expect(wrapper.contains('.ma-container-full__body')).toBeTruthy()
    expect(wrapper.contains('.ma-container-full__footer')).toBeTruthy()
  })

  // props
  it('has props', () => {
    const wrapper = mount(maContainerFull, {
      propsData: {
        scrollDelay: 30
      }
    })

    expect(wrapper.props().scrollDelay).toEqual(30)
  })

  // 渲染slot
  it('has one or more slots', () => {
    const wrapper = mount(maContainerFull, {
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
