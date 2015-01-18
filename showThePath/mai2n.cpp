#include <cstdlib>
#include <iostream>
#include <fstream>
#include "graph.h"
using namespace std;
struct  NODE1{
       int num;
       double x;
       double y;      
       };
#define max 1000
NODE1 node[max];
Graphmtx<int,double> Test(max);
int num = 0;
double a[max][max];
int path[max][max];
ifstream fileIn("Campus_1.txt");  
void readIn(){
     cout<<"loading data..."<<endl;
     fileIn>>num;
     for(int i=0;i<num;i++) Test.insertVertex(i);
     for(int i=0;i<num;i++){
             fileIn>>node[i].num>>node[i].x>>node[i].y;   
             }
     int v1,v2;
     while(fileIn>>v1>>v2){
                           v1--;
                           v2--;                          
                           double distance = (node[v1].x-node[v2].x)*(node[v1].x-node[v2].x)+(node[v1].y-node[v2].y)*(node[v1].y-node[v2].y);
                           Test.insertEdge(v1,v2,distance);
                           Test.insertEdge(v2,v1,distance);
                           }
     cout<<"loading successfully..."<<endl;
     }
void Floyd(){
     cout<<"go Floyd..."<<endl;
     int i,j,k,n = num;
     for(i=0;i<n;i++){
                      for(j=0;j<n;j++){
                                       a[i][j] = Test.getWeight(i,j);
                                       if(i!=j&&a[i][j]<maxWeight){
                                                                   path[i][j]=i;
                                                                   }
                                       else path[i][j]=0;
                                       }
                      }
     for(k=0;k<n;k++){
                       for(i=0;i<n;i++)
                       for(j=0;j<n;j++){
                                        if(i!=j&&((a[i][k]+a[k][j])<a[i][j])){
                                                                    a[i][j] = a[i][k] + a[k][j];
                                                                    path[i][j] = path[k][j];
                                                                    } 
                                        } 
                       }
     cout<<"Floyd done..."<<endl;
     }
void Output(){
     cout<<"putout result..."<<endl;
     ofstream outFile("PathResult_1.txt");
     int count=0,k,result[max];
     for(int i=0;i<num;i++){
            for(int j=0;j<num;j++){
                    k=j;
                    count=0;                   
                    outFile<<i+1<<" "<<j+1<<" "<<endl;
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
    readIn();
    Floyd();
    Output(); 
    system("PAUSE");
    return EXIT_SUCCESS;
}

