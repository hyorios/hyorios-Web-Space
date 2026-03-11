import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import ProjectCard from '../../app/components/ProjectCard.vue'

describe('ProjectCard.vue', () => {
  it('renders project data correctly', () => {
    const mockProject = {
      id: 1,
      title: { en: 'Test Project', de: 'Test Projekt' },
      slug: 'test-project',
      excerpt: { en: 'Test Excerpt', de: 'Test Zusammenfassung' },
      tech_stack: ['Vue', 'Nuxt'],
      thumbnail: 'https://example.com/test.jpg',
      is_featured: true
    }

    const wrapper = mount(ProjectCard, {
      props: {
        project: mockProject,
        locale: 'en'
      },
      global: {
        stubs: {
          NuxtLink: {
            template: '<a><slot></slot></a>'
          }
        }
      }
    })

    expect(wrapper.text()).toContain('Test Project')
    expect(wrapper.text()).toContain('Test Excerpt')
    expect(wrapper.text()).toContain('Vue')
    expect(wrapper.text()).toContain('Nuxt')
  })
})
