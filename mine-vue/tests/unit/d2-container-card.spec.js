import { mount } from '@vue/test-utils'
import maContainerCard from '@/components/ma-container/components/ma-container-card.vue'

describe('ma-container-card', () => {
  // 存在且是Vue组件实例
  it('is a vue instance', () => {
    const wrapper = mount(maContainerCard)

    expect(wrapper.exists()).toBeTruthy()
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  // 包含特定类名
  it('contains specific classnames', () => {
    const wrapper = mount(maContainerCard, {
      slots: {
        default: '<div>body</div>',
        header: '<div>header</div>',
        footer: '<div>footer</div>'
      }
    })

    expect(wrapper.is('.ma-container-card')).toBeTruthy()
    expect(wrapper.contains('.ma-container-card__header')).toBeTruthy()
    expect(wrapper.contains('.ma-container-card__body')).toBeTruthy()
    expect(wrapper.contains('.ma-container-card__body-card')).toBeTruthy()
    expect(wrapper.contains('.ma-container-card__footer')).toBeTruthy()
  })

  // props
  it('has props', () => {
    const wrapper = mount(maContainerCard, {
      propsData: {
        scrollDelay: 30
      }
    })

    expect(wrapper.props().scrollDelay).toEqual(30)
  })

  // 渲染slot
  it('has one or more slots', () => {
    const wrapper = mount(maContainerCard, {
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
