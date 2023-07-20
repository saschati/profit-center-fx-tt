import { useEffect } from 'react'
import useEffectEvent from './useEffectEvent'

const useElementWatcher = <T extends HTMLElement = HTMLElement>(
  ref: React.RefObject<T>,
  onWatch: (entry: IntersectionObserverEntry) => void
) => {
  const onAction = useEffectEvent(onWatch)

  useEffect(() => {
    const options = {
      root: null,
      rootMargin: '10px',
      threshold: 1.0,
    }

    const observer = new IntersectionObserver((entries) => {
      for (const entry of entries) {
        if (entry.isIntersecting) {
          onAction(entry)
        }
      }
    }, options)

    const element = ref.current

    observer.observe(element as Element)

    return () => {
      observer.unobserve(element as Element)
      observer.disconnect()
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [])
}

export default useElementWatcher
