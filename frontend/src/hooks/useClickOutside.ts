import { useEffect } from 'react'
import useEffectEvent from './useEffectEvent'

type ClickEvent = TouchEvent | MouseEvent

export const useClickOutside = <T extends HTMLElement = HTMLElement>(
  ref: React.RefObject<T>,
  handler: (event: ClickEvent) => void
) => {
  const onAction = useEffectEvent((event: ClickEvent) => handler(event))

  useEffect(() => {
    const listener = (event: ClickEvent) => {
      if (!ref.current || ref.current.contains(event.target as Node)) {
        return
      }

      onAction(event)
    }

    document.addEventListener('mousedown', listener)
    document.addEventListener('touchstart', listener)

    return () => {
      document.removeEventListener('mousedown', listener)
      document.removeEventListener('touchstart', listener)
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [])
}
