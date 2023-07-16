import { useRef } from 'react'

const useEffectEvent = <T extends (...args: Parameters<T>) => void>(callback: T): T => {
  const ref = useRef(callback)

  ref.current = callback

  return ((...args: Parameters<T>): void => {
    ref.current(...args)
  }) as T
}

export default useEffectEvent
