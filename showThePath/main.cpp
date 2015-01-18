#include <iostream>
#include <fstream>
using namespace std;
 
/*
 * �ڵ㶨�壬numΪ�ڵ�id��x��y�ֱ�Ϊ���ݰٷֱ� 
 */
struct  NODE{
       int num;
       double x;
       double y;      
       };
#define max 1000                            //���ڵ��� 
const double maxWeight=1000000000.0;       //�������ֵ 
NODE node[max];                            //�������нڵ�ֵ 
int num = 0;                               //�ڵ��� 
double weight[max][max];                   //����ͼ���������ڵ�ľ��룻ͬһ���㣺weight=0����ͬ��������ͨ��weight=distance����ͬ�����Ҳ���ͨ��weight=maxWeight 
double a[max][max];                        //����ͼ����������֮������·������ 
int path[max][max];                        //��¼���·����·�� 
ifstream fileIn("Campus_1.txt",ios::in);   //�ڵ������ļ� 
/*
 * ���ļ��ж�ȡ�ڵ����ݣ�����ʼ����ر��� 
 */
void readIn(){
     cout<<"loading data..."<<endl;
     fileIn>>num;
     for(int i=0;i<num;i++){
             fileIn>>node[i].num>>node[i].x>>node[i].y;   
             }
     int v1,v2;
     for(int i=0;i<num;i++)
     for(int j=0;j<num;j++){
             if(i==j)weight[i][j]=0;
             else weight[i][j]=maxWeight;
             }
     /*
      * ��ȡ�����ڵ㣬���ʾΪid�ţ���node���num 
      */
   /*  while(fileIn>>v1>>v2){ 
                           int flagV1=0,flagV2=0;
                           for(int l=0;l<num;l++){
                                   if(node[l].num==v1&&flagV1==0)flagV1=l;
                                   if(node[l].num==v2&&flagV2==0)flagV2=l;
                                   }        
                           v1=flagV1;v2=flagV2;                
                           double distance = (node[v1].x-node[v2].x)*(node[v1].x-node[v2].x)+(node[v1].y-node[v2].y)*(node[v1].y-node[v2].y);
                           //��ͨ������ͼ��������ͼ����ʵ��������ͨ����ͼ�� 
                           weight[v1][v2] = distance;    
                           weight[v2][v1] = distance;
                           }
     */
     int v2Num=0;
     int V1=0,V2=0;
     while(fileIn>>v1){
                       for(int l=0;l<num;l++)
                       if(node[l].num==v1){V1=l;break;} 
                       v2Num=0;
                       fileIn>>v2Num;
                       if(v2Num!=0){
                                    for(int k=0;k<v2Num;k++){
                                            fileIn>>v2;
                                            for(int l=0;l<num;l++)
                                            if(node[l].num==v2){V2=l;break;}
                                            double distance = (node[V1].x-node[V2].x)*(node[V1].x-node[V2].x)+(node[V1].y-node[V2].y)*(node[V1].y-node[V2].y);
                                            weight[V2][V1] = distance;
                                            weight[V1][V2] = distance;                                                   
                                            }
                                    }
                       } 
     cout<<"loading successfully..."<<endl;
     }
/*
 * ���������㷨����ͼ����������֮������·�� 
 */
void Floyd(){
    cout<<"go Floyd..."<<endl;
    int i,j,k,n = num;
    for(i=0;i<n;i++)
    for(j=0;j<n;j++){
				   a[i][j] = weight[i][j];
				   if(i!=j&&a[i][j]<maxWeight) path[i][j]=i;                                                                   
				   else path[i][j]=0;
				   }                   
    for(k=0;k<n;k++)
    for(i=0;i<n;i++)
    for(j=0;j<n;j++)
	if(i!=j&&((a[i][k]+a[k][j])<a[i][j])){
								a[i][j] = a[i][k] + a[k][j];
								path[i][j] = path[k][j];
								} 
					
                      
     cout<<"Floyd done..."<<endl;
     }
/*
 * ���ͼ��������������·�� 
 */
void Output(){
     cout<<"putout result..."<<endl;
     ofstream outFile("PathResult_1.txt",ios::out);
     int count=0,k,result[max];
     for(int i=0;i<num;i++){
            for(int j=0;j<num;j++){
                    k=j;
                    count=0;                   
                    outFile<<node[i].num<<" "<<node[j].num<<" "<<endl;
                    if(i==j){result[count++]=i;}
                    else{
                        do{
                         result[count++]=k;
                         k=path[i][k];            
                         }while(path[i][k]!=0);
                         result[count++]=i;                    
                     }
            outFile<<count<<" "<<endl;
            for(int l=count-1;l>=0;l--){
                   outFile<<node[result[l]].x<<" "<<node[result[l]].y<<" ";
                   }
            outFile<<endl;
            }
    }
    cout<<"all done,please check the result file named out.txt."<<endl;
     }

int main(int argc, char *argv[])
{
    readIn();     //��ȡ�ڵ��ļ� 
    Floyd();      //�������·�� 
    Output();     //������ 
    system("PAUSE");
    return EXIT_SUCCESS;
}

