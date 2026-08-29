import mitt from 'mitt'

const mittInstance = mitt()

export function useMitt() {
  return mittInstance
}
