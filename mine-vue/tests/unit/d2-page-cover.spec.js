import { mount } from '@vue/test-utils'
import maPageCover from '@/components/ma-page-cover/index.vue'

describe('ma-page-cover', () => {
  // 存在且是Vue组件实例
  it('is a vue instance', () => {
    const wrapper = mount(maPageCover)

    expect(wrapper.exists()).toBeTruthy()
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  // 包含特定类名
  it('contains specific classnames', () => {
    const wrapper = mount(maPageCover, {
      slots: {
        default: '<div>default</div>',
        footer: '<div>footer</div>'
      }
    })

    expect(wrapper.is('.ma-page-cover')).toBeTruthy()
    expect(wrapper.contains('.ma-page-cover__logo')).toBeTruthy()
    expect(wrapper.contains('.ma-page-cover__title')).toBeTruthy()
    expect(wrapper.contains('.ma-page-cover__sub-title')).toBeTruthy()
    expect(wrapper.contains('.ma-page-cover__build-time')).toBeTruthy()
  })

  // 渲染slot
  it('has one or more slots', () => {
    const wrapper = mount(maPageCover, {
      slots: {
        default: '<div>default</div>',
        footer: '<div>footer</div>'
      }
    })

    expect(wrapper.text()).toMatch('default')
    expect(wrapper.text()).toMatch('footer')
  })
})
