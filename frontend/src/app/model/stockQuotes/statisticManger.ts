import { SummaryStatisticData } from '@/types/model/stockQuotes'

type CacheType = 'max' | 'min' | 'average' | 'standardDeviation' | 'mode'

export class StatisticStockQuotesManager {
  private cacheCalc: Map<CacheType, number> = new Map()

  constructor(private values: number[] = []) {}

  public setValue(value: number): StatisticStockQuotesManager {
    this.values.push(value)

    this.cacheCalc = new Map()

    return this
  }

  public getAverage(): number {
    return this.cacheSetOrGet('average', () => this.values.reduce((acc, cur) => acc + cur) / this.values.length)
  }

  public getMax(): number {
    return this.cacheSetOrGet('max', () => Math.max(...this.values))
  }

  public getMin(): number {
    return this.cacheSetOrGet('min', () => Math.min(...this.values))
  }

  public getStandardDeviation(): number {
    return this.cacheSetOrGet('standardDeviation', () => {
      const average = this.getAverage()
      const averageDeviation = this.values.reduce((acc, cur) => acc + Math.pow(cur - average, 2)) / this.values.length

      return Math.sqrt(averageDeviation)
    })
  }

  public getMode(): number {
    return this.cacheSetOrGet('mode', () => {
      const modes = new Map<number, number>()
      let maxCount = 0
      let maxMode = 0

      for (let i = 0; i < this.values.length; i++) {
        const val = this.values[i]
        modes.set(val, (modes.get(val) || 0) + 1)

        const modeCount = modes.get(val) as number
        if (modeCount > maxCount) {
          maxCount = modeCount
          maxMode = val
        }
      }

      return maxMode
    })
  }

  public getSummaryStatisticData(): SummaryStatisticData {
    return {
      average: this.getAverage(),
      max: this.getMax(),
      min: this.getMin(),
      standardDeviation: this.getStandardDeviation(),
      mode: this.getMode(),
    }
  }

  public clone(): StatisticStockQuotesManager {
    return new StatisticStockQuotesManager(this.values.slice())
  }

  private cacheSetOrGet(name: CacheType, calc: () => number): number {
    if (!this.cacheCalc.has(name)) {
      const val = calc()

      this.cacheCalc.set(name, val)
    }

    return this.cacheCalc.get(name) || 0
  }
}
