import LocalStorage from '@/app/storage/local'
import SessionStorage from '@/app/storage/session'
import { ValueOf } from '@/types/utils'

export const STORAGE_TYPE = {
  LOCAL: 'local',
  SESSION: 'session',
} as const

type StorageTypeValue = ValueOf<typeof STORAGE_TYPE>

type StorageMap = {
  [STORAGE_TYPE.LOCAL]: LocalStorage
  [STORAGE_TYPE.SESSION]: SessionStorage
}

const storages = new Map<ValueOf<StorageTypeValue>, StorageMap[StorageTypeValue]>([
  [STORAGE_TYPE.LOCAL, new LocalStorage()],
  [STORAGE_TYPE.SESSION, new SessionStorage()],
])

const useStorage = <T extends StorageTypeValue>(type: T): StorageMap[T] => {
  const storage = storages.get(type)

  if (!storage) {
    throw new Error(`Storage can't be found.`)
  }

  return storage
}

export default useStorage
